using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurger.Web.Models.Entities
{
    [Table("menus")]
    public class Menu
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("nom")]
        [StringLength(100)]
        public string Nom { get; set; }

        [Column("description")]
        public string? Description { get; set; }

        [Column("prix")]
        public decimal Prix { get; set; }

        [Column("image")]
        public string? Image { get; set; }

        // Navigation or additional properties
        public Burger? Burger { get; set; }
        public Complement? Boisson { get; set; }
    }
}