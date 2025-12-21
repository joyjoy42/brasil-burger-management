using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Authorization;
using System.Security.Claims;
using System.Text.Json;
using BrasilBurger.Web.Models.ViewModels;
using BrasilBurger.Web.Services;

namespace BrasilBurger.Web.Controllers
{
    [Authorize]
    public class CommandeController : Controller
    {
        private readonly ICommandeService _commandeService;
        private readonly ICatalogueService _catalogueService;
        private const string PanierSessionKey = "Panier";

        public CommandeController(ICommandeService commandeService, ICatalogueService catalogueService)
        {
            _commandeService = commandeService;
            _catalogueService = catalogueService;
        }

        // Ajouter au panier
        [HttpPost]
        public async Task<IActionResult> AjouterAuPanier(string type, int id, int quantite = 1, int[]? complementIds = null)
        {
            var panier = GetPanier();

            if (type == "burger")
            {
                var burger = await _catalogueService.GetBurgerByIdAsync(id);
                if (burger == null)
                    return NotFound();

                var item = new PanierItemViewModel
                {
                    Type = "burger",
                    ProduitId = burger.Id,
                    Nom = burger.Nom,
                    PrixUnitaire = burger.Prix,
                    Quantite = quantite
                };

                // Ajouter les compléments sélectionnés
                if (complementIds != null && complementIds.Length > 0)
                {
                    foreach (var compId in complementIds)
                    {
                        var complement = await _catalogueService.GetComplementByIdAsync(compId);
                        if (complement != null)
                        {
                            item.Complements.Add(complement.Nom);
                        }
                    }
                }

                panier.Items.Add(item);
            }
            else if (type == "menu")
            {
                var menu = await _catalogueService.GetMenuByIdAsync(id);
                if (menu == null)
                    return NotFound();

                var item = new PanierItemViewModel
                {
                    Type = "menu",
                    ProduitId = menu.Id,
                    Nom = menu.Nom,
                    PrixUnitaire = menu.Prix,
                    Quantite = quantite
                };

                panier.Items.Add(item);
            }

            SavePanier(panier);
            TempData["SuccessMessage"] = "Produit ajouté au panier !";

            return RedirectToAction("Panier");
        }

        // Afficher le panier
        public IActionResult Panier()
        {
            var panier = GetPanier();
            return View(panier);
        }

        // Supprimer du panier
        [HttpPost]
        public IActionResult SupprimerDuPanier(int index)
        {
            var panier = GetPanier();

            if (index >= 0 && index < panier.Items.Count)
            {
                panier.Items.RemoveAt(index);
                SavePanier(panier);
                TempData["SuccessMessage"] = "Produit supprimé du panier";
            }

            return RedirectToAction("Panier");
        }

        // Modifier quantité
        [HttpPost]
        public IActionResult ModifierQuantite(int index, int quantite)
        {
            if (quantite <= 0)
                return RedirectToAction("Panier");

            var panier = GetPanier();

            if (index >= 0 && index < panier.Items.Count)
            {
                panier.Items[index].Quantite = quantite;
                SavePanier(panier);
            }

            return RedirectToAction("Panier");
        }

        // Vider le panier
        [HttpPost]
        public IActionResult ViderPanier()
        {
            HttpContext.Session.Remove(PanierSessionKey);
            TempData["SuccessMessage"] = "Panier vidé";
            return RedirectToAction("Panier");
        }

        // Choisir le type de livraison
        [HttpPost]
        public IActionResult ChoisirLivraison(string typeLivraison, int? zoneId)
        {
            var panier = GetPanier();
            panier.TypeLivraison = NormalizeTypeLivraison(typeLivraison) ?? panier.TypeLivraison;
            panier.ZoneId = zoneId;
            SavePanier(panier);

            return RedirectToAction("Confirmation");
        }

        private static string? NormalizeTypeLivraison(string? raw)
        {
            if (string.IsNullOrWhiteSpace(raw))
                return null;

            var n = raw.Trim().ToLowerInvariant();
            n = n.Replace(" ", "_").Replace("-", "_");

            // Accept common french variants
            if (n == "surplace" || n == "sur_place" || n == "sur-place")
                return "sur_place";
            if (n == "arecuperer" || n == "a_recuperer" || n == "a-recuperer" || n == "a recuperer")
                return "a_recuperer";
            if (n == "livraison")
                return "livraison";

            return n; // fallback: already normalized form
        }

        // Confirmation de la commande
        public IActionResult Confirmation()
        {
            var panier = GetPanier();

            if (panier.Items.Count == 0)
            {
                TempData["ErrorMessage"] = "Votre panier est vide";
                return RedirectToAction("Panier");
            }

            var viewModel = new CommandeViewModel
            {
                Panier = panier,
                TypeLivraison = panier.TypeLivraison,
                ZoneId = panier.ZoneId
            };

            return View(viewModel);
        }

        // Valider la commande
        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ValiderCommande(CommandeViewModel model)
        {
            var panier = GetPanier();

            if (panier.Items.Count == 0)
            {
                TempData["ErrorMessage"] = "Votre panier est vide";
                return RedirectToAction("Panier");
            }

            // Récupérer l'ID du client connecté
            var clientId = int.Parse(User.FindFirstValue(ClaimTypes.NameIdentifier));

            model.Panier = panier;

            // Créer la commande
            var commande = await _commandeService.CreateCommandeAsync(clientId, model);

            if (commande == null)
            {
                TempData["ErrorMessage"] = "Une erreur est survenue lors de la création de la commande";
                return RedirectToAction("Confirmation");
            }

            // Vider le panier
            HttpContext.Session.Remove(PanierSessionKey);

            TempData["SuccessMessage"] = "Commande validée avec succès !";
            return RedirectToAction("Details", "Suivi", new { id = commande.Id });
        }

        // Méthodes privées pour gérer le panier en session
        private PanierViewModel GetPanier()
        {
            var panierJson = HttpContext.Session.GetString(PanierSessionKey);
            
            if (string.IsNullOrEmpty(panierJson))
                return new PanierViewModel();

            return JsonSerializer.Deserialize<PanierViewModel>(panierJson) ?? new PanierViewModel();
        }

        private void SavePanier(PanierViewModel panier)
        {
            var panierJson = JsonSerializer.Serialize(panier);
            HttpContext.Session.SetString(PanierSessionKey, panierJson);
        }
    }
}