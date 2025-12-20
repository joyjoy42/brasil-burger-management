using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Authorization;
using System.Security.Claims;
using System;
using BrasilBurger.Web.Models.ViewModels;
using BrasilBurger.Web.Services;

namespace BrasilBurger.Web.Controllers
{
    [Authorize]
    public class SuiviController : Controller
    {
        private readonly ICommandeService _commandeService;

        public SuiviController(ICommandeService commandeService)
        {
            _commandeService = commandeService;
        }

        // Liste des commandes du client
        public async Task<IActionResult> MesCommandes(string? filtre)
        {
            var clientId = int.Parse(User.FindFirstValue(ClaimTypes.NameIdentifier));
            var commandes = await _commandeService.GetCommandesByClientAsync(clientId);

            // Normaliser le filtre fourni (ex: "en attente" -> "en_attente")
            string? filtreNormalise = null;
            if (!string.IsNullOrWhiteSpace(filtre))
            {
                filtreNormalise = filtre.Trim().ToLowerInvariant().Replace(" ", "_").Replace("-", "_");
            }

            // Appliquer le filtre par état si nécessaire
            if (!string.IsNullOrEmpty(filtreNormalise) && filtreNormalise != "all")
            {
                commandes = commandes
                    .Where(c => string.Equals(c.Etat?.Trim().ToLowerInvariant(), filtreNormalise, StringComparison.OrdinalIgnoreCase))
                    .ToList();
            }

            var viewModel = new SuiviCommandeViewModel
            {
                Commandes = commandes,
                FiltreEtat = filtreNormalise
            };

            return View(viewModel);
        }

        // Détails d'une commande
        public async Task<IActionResult> Details(int id)
        {
            var commande = await _commandeService.GetCommandeByIdAsync(id);

            if (commande == null)
                return NotFound();

            // Vérifier que la commande appartient bien au client connecté
            var clientId = int.Parse(User.FindFirstValue(ClaimTypes.NameIdentifier));
            if (commande.ClientId != clientId)
                return Forbid();

            return View(commande);
        }

        // Obtenir l'état d'une commande en temps réel (pour AJAX)
        [HttpGet]
        public async Task<IActionResult> GetEtatCommande(int id)
        {
            var commande = await _commandeService.GetCommandeByIdAsync(id);

            if (commande == null)
                return NotFound();

            // Vérifier que la commande appartient bien au client connecté
            var clientId = int.Parse(User.FindFirstValue(ClaimTypes.NameIdentifier));
            if (commande.ClientId != clientId)
                return Forbid();

            return Json(new
            {
                etat = commande.Etat,
                numero = commande.Numero,
                dateCommande = commande.DateCommande.ToString("dd/MM/yyyy HH:mm")
            });
        }
    }
}