using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurger.Web.Models.Entities
{
    [Table("zone_livraison")]
    public class ZoneLivraison
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("nom")]
        [StringLength(255)]
        public string Nom { get; set; }

        [Required]
        [Column("prix_livraison")]
        public decimal PrixLivraison { get; set; }

        [Required]
        [Column("quartiers")]
        public string Quartiers { get; set; }
    }
}
