using BrasilBurger.Web.Models.Entities;
using System.Collections.Generic;

namespace BrasilBurger.Web.Models.ViewModels
{
    public class SuiviCommandeViewModel
    {
        public List<Commande> Commandes { get; set; } = new();
        public string FiltreEtat { get; set; }
    }
}