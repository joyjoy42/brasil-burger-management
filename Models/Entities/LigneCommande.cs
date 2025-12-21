using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurger.Web.Models.Entities
{
    [Table("lignes_commande")]
    public class LigneCommande
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Column("commande_id")]
        public int CommandeId { get; set; }

        [Required]
        [Column("type_produit")]
        [StringLength(20)]
        public string TypeProduit { get; set; }

        [Column("produit_id")]
        public int ProduitId { get; set; }

        [Column("quantite")]
        public int Quantite { get; set; }

        [Column("prix_unitaire")]
        public decimal PrixUnitaire { get; set; }

        [Column("complements")]
        public string? Complements { get; set; }

        // Navigation
        [ForeignKey("CommandeId")]
        public virtual Commande Commande { get; set; }
    }
}