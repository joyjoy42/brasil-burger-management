using BrasilBurger.Web.Models.Entities;
using System.Collections.Generic;
using System.Threading.Tasks;

namespace BrasilBurger.Web.Services
{
    public interface ICatalogueService
    {
        Task<List<Burger>> GetBurgersAsync(bool includeArchived = false);
        Task<List<Menu>> GetMenusAsync(bool includeArchived = false);
        Task<List<Complement>> GetComplementsAsync(bool includeArchived = false);
        Task<Burger?> GetBurgerByIdAsync(int id);
        Task<Menu?> GetMenuByIdAsync(int id);
        Task<Complement?> GetComplementByIdAsync(int id);
    }
}