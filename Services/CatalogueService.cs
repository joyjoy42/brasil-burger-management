using BrasilBurger.Web.Data;
using BrasilBurger.Web.Models.Entities;
using Microsoft.EntityFrameworkCore;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace BrasilBurger.Web.Services
{
    public class CatalogueService : ICatalogueService
    {
        private readonly AppDbContext _context;

        public CatalogueService(AppDbContext context)
        {
            _context = context;
        }

        public async Task<List<Burger>> GetBurgersAsync(bool includeArchived = false)
        {
            var query = _context.Burgers.AsQueryable();
            if (!includeArchived)
            {
                // Assume Burger has Archive property, but it doesn't. For now, return all.
            }
            return await query.ToListAsync();
        }

        public async Task<List<Menu>> GetMenusAsync(bool includeArchived = false)
        {
            var query = _context.Menus.AsQueryable();
            if (!includeArchived)
            {
                // Assume Menu has Archive property
            }
            return await query.ToListAsync();
        }

        public async Task<List<Complement>> GetComplementsAsync(bool includeArchived = false)
        {
            var query = _context.Complements.AsQueryable();
            if (!includeArchived)
            {
                query = query.Where(c => !c.Archive);
            }
            return await query.ToListAsync();
        }

        public async Task<Burger?> GetBurgerByIdAsync(int id)
        {
            return await _context.Burgers.FindAsync(id);
        }

        public async Task<Menu?> GetMenuByIdAsync(int id)
        {
            return await _context.Menus.FindAsync(id);
        }

        public async Task<Complement?> GetComplementByIdAsync(int id)
        {
            return await _context.Complements.FindAsync(id);
        }
    }
}