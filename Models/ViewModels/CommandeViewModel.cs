namespace BrasilBurger.Web.Models.ViewModels
{
    public class CommandeViewModel
    {
        public PanierViewModel Panier { get; set; }
        public string TypeLivraison { get; set; }
        public int? ZoneId { get; set; }
        public string MethodePaiement { get; set; }
    }
}