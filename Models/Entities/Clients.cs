using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurger.Web.Models.Entities
{
    [Table("clients")]
    public class Client
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("nom")]
        [StringLength(100)]
        public string Nom { get; set; }

        [Required]
        [Column("prenom")]
        [StringLength(100)]
        public string Prenom { get; set; }

        [Required]
        [Column("telephone")]
        [StringLength(20)]
        public string Telephone { get; set; }

        [Required]
        [Column("email")]
        [StringLength(150)]
        public string Email { get; set; }

        [Required]
        [Column("password")]
        public string Password { get; set; }

        [Column("adresse")]
        [StringLength(255)]
        public string? Adresse { get; set; }

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;

        // Navigation
        public virtual ICollection<Commande> Commandes { get; set; }
    }
}