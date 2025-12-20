using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurger.Web.Models.Entities
{
    [Table("complements")]
    public class Complement
    {
        [Key]
        [Column("id")]
        public int Id { get; set; }

        [Required]
        [Column("nom")]
        [StringLength(100)]
        public string Nom { get; set; }

        [Required]
        [Column("type")]
        [StringLength(50)]
        public string Type { get; set; } // "frite" ou "boisson"

        [Required]
        [Column("prix")]
        public decimal Prix { get; set; }

        [Column("image")]
        [StringLength(255)]
        public string? Image { get; set; }

        [Column("archive")]
        public bool Archive { get; set; } = false;

        [Column("created_at")]
        public DateTime CreatedAt { get; set; } = DateTime.Now;
    }
}
