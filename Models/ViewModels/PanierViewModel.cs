using System.Collections.Generic;
using System.Linq;

namespace BrasilBurger.Web.Models.ViewModels
{
    public class PanierViewModel
    {
        public List<PanierItemViewModel> Items { get; set; } = new();
        public decimal Total => Items.Sum(item => item.SousTotal);
        public string TypeLivraison { get; set; }
        public int? ZoneId { get; set; }
    }

    public class PanierItemViewModel
    {
        public string Type { get; set; }
        public int ProduitId { get; set; }
        public int Quantite { get; set; }
        public decimal PrixUnitaire { get; set; }
        public List<string> Complements { get; set; } = new();
        public string Nom { get; set; }
        public decimal SousTotal => Quantite * PrixUnitaire;
    }
}