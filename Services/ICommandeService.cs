using BrasilBurger.Web.Models.Entities;
using BrasilBurger.Web.Models.ViewModels;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace BrasilBurger.Web.Services
{
    public interface ICommandeService
    {
        Task<Commande?> CreateCommandeAsync(int clientId, CommandeViewModel model);
        Task<List<Commande>> GetCommandesByClientAsync(int clientId);
        Task<Commande?> GetCommandeByIdAsync(int id);
        string GenerateNumeroCommande();
    }
}