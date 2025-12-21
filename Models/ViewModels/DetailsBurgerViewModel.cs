using BrasilBurger.Web.Models.Entities;
using System.Collections.Generic;

namespace BrasilBurger.Web.Models.ViewModels
{
    public class DetailsBurgerViewModel
    {
        public Burger Burger { get; set; }
        public List<Complement> ComplementsDisponibles { get; set; } = new();
    }
}