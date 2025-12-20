using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurger.Web.Models.Entities
{
    [Table("paiements")]
    public class Paiement
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("commande_id")]
        public int CommandeId { get; set; }

        [Required]
        [Column("montant")]
        public decimal Montant { get; set; }

        [Required]
        [Column("methode")]
        [StringLength(50)]
        public string Methode { get; set; } // "wave" ou "om"

        [Required]
        [Column("date_paiement")]
        public DateTime DatePaiement { get; set; } = DateTime.Now;

        [Column("reference")]
        [StringLength(100)]
        public string? Reference { get; set; }

        [Column("statut")]
        [StringLength(50)]
        public string Statut { get; set; } = "success"; // success, pending, failed

        // Navigation
        [ForeignKey("CommandeId")]
        public virtual Commande Commande { get; set; }
    }
}