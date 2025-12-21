using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurger.Web.Models.Entities
{
    [Table("commandes")]
    public class Commande
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("numero")]
        [StringLength(50)]
        public string Numero { get; set; }

        [Column("client_id")]
        public int ClientId { get; set; }

        [Column("type_livraison")]
        [StringLength(20)]
        public string? TypeLivraison { get; set; }

        [Column("zone_id")]
        public int? ZoneId { get; set; }

        [Column("montant_total")]
        public decimal MontantTotal { get; set; }

        [Required]
        [Column("etat")]
        [StringLength(20)]
        public string Etat { get; set; }

        [Column("date_commande")]
        public DateTime DateCommande { get; set; }

        // Navigation
        [ForeignKey("ClientId")]
        public virtual Client Client { get; set; }

        public virtual ICollection<LigneCommande> LignesCommande { get; set; }
        public virtual Paiement Paiement { get; set; }
    }
}