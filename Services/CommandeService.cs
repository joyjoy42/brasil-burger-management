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

                var commande = new Commande
                {
                    Numero = GenerateNumeroCommande(),
                    ClientId = clientId,
                    TypeLivraison = NormalizeTypeLivraison(typeLiv),
                    ZoneId = model.ZoneId,
                    MontantTotal = model.Panier.Total,
                    Etat = "validee", // Validée après paiement
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

                // Créer le paiement
                var paiement = new Paiement
                {
                    CommandeId = commande.Id,
                    Montant = model.Panier.Total,
                    Methode = model.MethodePaiement,
                    DatePaiement = DateTime.Now,
                    Statut = "success",
                    Reference = $"PAY-{commande.Numero}-{DateTime.Now:yyyyMMddHHmmss}"
                };

                _context.Paiements.Add(paiement);
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