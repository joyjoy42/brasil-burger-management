using Microsoft.AspNetCore.Mvc;
using BrasilBurger.Web.Models.ViewModels;
using BrasilBurger.Web.Services;
using System;

namespace BrasilBurger.Web.Controllers
{
    public class CatalogueController : Controller
    {
        private readonly ICatalogueService _catalogueService;

        public CatalogueController(ICatalogueService catalogueService)
        {
            _catalogueService = catalogueService;
        }

        public async Task<IActionResult> Index(string? filtre, string? search)
        {
            FilterType parsedFilter = FilterType.All;
            if (!string.IsNullOrEmpty(filtre) && Enum.TryParse<FilterType>(filtre, true, out var pf))
            {
                parsedFilter = pf;
            }

            var viewModel = new CatalogueViewModel
            {
                FiltreType = parsedFilter,
                SearchTerm = search
            };

            if (parsedFilter == FilterType.All || parsedFilter == FilterType.Burger)
            {
                viewModel.Burgers = await _catalogueService.GetBurgersAsync(viewModel.IncludeArchived);
            }

            if (parsedFilter == FilterType.All || parsedFilter == FilterType.Menu)
            {
                viewModel.Menus = await _catalogueService.GetMenusAsync(viewModel.IncludeArchived);
            }

            viewModel.Complements = await _catalogueService.GetComplementsAsync(viewModel.IncludeArchived);

            // Appliquer la recherche si nécessaire
            if (!string.IsNullOrEmpty(search))
            {
                viewModel.Burgers = viewModel.Burgers
                    .Where(b => b.Nom.Contains(search, StringComparison.OrdinalIgnoreCase))
                    .ToList();
                
                viewModel.Menus = viewModel.Menus
                    .Where(m => m.Nom.Contains(search, StringComparison.OrdinalIgnoreCase))
                    .ToList();
            }

            return View(viewModel);
        }

        public async Task<IActionResult> DetailsBurger(int id)
        {
            var burger = await _catalogueService.GetBurgerByIdAsync(id);
            
            if (burger == null)
                return NotFound();

            var viewModel = new DetailsBurgerViewModel
            {
                Burger = burger,
                ComplementsDisponibles = await _catalogueService.GetComplementsAsync()
            };

            return View(viewModel);
        }

        public async Task<IActionResult> DetailsMenu(int id)
        {
            var menu = await _catalogueService.GetMenuByIdAsync(id);
            
            if (menu == null)
                return NotFound();

            var viewModel = new DetailsMenuViewModel
            {
                Menu = menu
            };

            return View(viewModel);
        }
    }
}