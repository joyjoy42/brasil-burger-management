using Microsoft.EntityFrameworkCore;
using BrasilBurger.Web.Data;
using BrasilBurger.Web.Models.Entities;
using BrasilBurger.Web.Models.ViewModels;
using System.Text.Json;

namespace BrasilBurger.Web.Services
{
    public class CommandeService : ICommandeService
    {
        private readonly AppDbContext _context;

        public CommandeService(AppDbContext context)
        {
            _context = context;
        }

        public async Task<Commande?> CreateCommandeAsync(int clientId, CommandeViewModel model)
        {
            using var transaction = await _context.Database.BeginTransactionAsync();
            try
            {
                // Créer la commande
                var typeLiv = model.TypeLivraison;
                if (string.IsNullOrWhiteSpace(typeLiv))
                    typeLiv = model.Panier?.TypeLivraison;

                // Vérifier que le panier n'est pas vide
                if (model.Panier == null || !model.Panier.Items.Any())
                {
                    return null;
                }

                // Créer la commande avec état initial "en_attente_paiement"
                var commande = new Commande
                {
                    Numero = GenerateNumeroCommande(),
                    ClientId = clientId,
                    TypeLivraison = NormalizeTypeLivraison(typeLiv),
                    ZoneId = model.ZoneId,
                    MontantTotal = model.Panier.Total,
                    Etat = "en_attente_paiement", // État initial : en attente de paiement
                    DateCommande = DateTime.Now
                };

                _context.Commandes.Add(commande);
                await _context.SaveChangesAsync();

                // Créer les lignes de commande
                foreach (var item in model.Panier.Items)
                {
                    var ligne = new LigneCommande
                    {
                        CommandeId = commande.Id,
                        TypeProduit = item.Type,
                        ProduitId = item.ProduitId,
                        Quantite = item.Quantite,
                        PrixUnitaire = item.PrixUnitaire,
                        Complements = JsonSerializer.Serialize(item.Complements)
                    };

                    _context.LignesCommande.Add(ligne);
                }

                // Vérifier qu'une commande ne peut être payée qu'une seule fois
                var existingPaiement = await _context.Paiements
                    .FirstOrDefaultAsync(p => p.CommandeId == commande.Id);
                
                if (existingPaiement != null)
                {
                    // Commande déjà payée, annuler la transaction
                    await transaction.RollbackAsync();
                    return null;
                }

                // Créer le paiement
                var paiement = new Paiement
                {
                    CommandeId = commande.Id,
                    Montant = model.Panier.Total,
                    Methode = model.MethodePaiement ?? "wave", // Par défaut Wave
                    DatePaiement = DateTime.Now,
                    Statut = "success", // Simulation : en production, vérifier avec l'API
                    Reference = $"PAY-{commande.Numero}-{DateTime.Now:yyyyMMddHHmmss}"
                };

                _context.Paiements.Add(paiement);
                await _context.SaveChangesAsync();

                // Après paiement réussi, mettre la commande à "validee"
                commande.Etat = "validee";
                await _context.SaveChangesAsync();

                await transaction.CommitAsync();
                return commande;
            }
            catch
            {
                await transaction.RollbackAsync();
                return null;
            }
        }

        private static string? NormalizeTypeLivraison(string? raw)
        {
            if (string.IsNullOrWhiteSpace(raw))
                return null;

            var n = raw.Trim().ToLowerInvariant();
            n = n.Replace(" ", "_").Replace("-", "_");

            if (n == "surplace" || n == "sur_place" || n == "sur-place")
                return "sur_place";
            if (n == "arecuperer" || n == "a_recuperer" || n == "a-recuperer" || n == "a recuperer")
                return "a_recuperer";
            if (n == "livraison")
                return "livraison";

            return n;
        }

        public async Task<List<Commande>> GetCommandesByClientAsync(int clientId)
        {
            return await _context.Commandes
                .Include(c => c.LignesCommande)
                .Include(c => c.Paiement)
                .Where(c => c.ClientId == clientId)
                .OrderByDescending(c => c.DateCommande)
                .ToListAsync();
        }

        public async Task<Commande?> GetCommandeByIdAsync(int id)
        {
            return await _context.Commandes
                .Include(c => c.Client)
                .Include(c => c.LignesCommande)
                .Include(c => c.Paiement)
                .FirstOrDefaultAsync(c => c.Id == id);
        }

        public string GenerateNumeroCommande()
        {
            return $"CMD-{DateTime.Now:yyyyMMdd}-{Guid.NewGuid().ToString().Substring(0, 8).ToUpper()}";
        }
    }
}