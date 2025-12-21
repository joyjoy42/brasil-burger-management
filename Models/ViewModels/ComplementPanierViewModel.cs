namespace BrasilBurger.Web.Models.ViewModels
{
    public class ComplementPanierViewModel
    {
        public int Id { get; set; }
        public int ComplementId { get; set; }
        public string Nom { get; set; }
        public decimal Prix { get; set; }
    }
}