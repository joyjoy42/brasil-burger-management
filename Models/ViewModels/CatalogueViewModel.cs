using BrasilBurger.Web.Models.Entities;
using System.Collections.Generic;

namespace BrasilBurger.Web.Models.ViewModels
{
    public enum FilterType
    {
        All,
        Burger,
        Menu
    }

    public enum ConsumptionType
    {
        SurPlace,
        ARecuperer,
        Livraison
    }

    public class CatalogueViewModel
    {
        public List<Burger> Burgers { get; set; } = new List<Burger>();
        public List<Menu> Menus { get; set; } = new List<Menu>();
        public List<Complement> Complements { get; set; } = new List<Complement>();

        // Filtering / search
        public FilterType? FiltreType { get; set; }
        public string? SearchTerm { get; set; }

        // Selection / navigation (used when starting an order from the catalogue)
        public int? SelectedBurgerId { get; set; }
        public int? SelectedMenuId { get; set; }
        public List<int> SelectedComplementIds { get; set; } = new List<int>();
        public ConsumptionType? SelectedConsumptionType { get; set; }

        // Admin / listing options
        public bool IncludeArchived { get; set; } = false;

        // Paging / sorting (optional)
        public int Page { get; set; } = 1;
        public int PageSize { get; set; } = 20;
        public string? SortBy { get; set; }

        // Helper: prices precomputed for menus if needed by the view
        public Dictionary<int, decimal> MenuPrices { get; set; } = new Dictionary<int, decimal>();
    }
}