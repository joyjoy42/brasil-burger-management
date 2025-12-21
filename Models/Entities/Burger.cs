using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurger.Web.Models.Entities
{
    [Table("burgers")]
    public class Burger
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

        // Add other properties as needed
    }
}