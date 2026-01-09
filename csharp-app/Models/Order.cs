using System.ComponentModel.DataAnnotations;

namespace BrasilBurgerClient.Models;

public enum OrderStatus { PENDING, PAID, READY, FINISHED, DELIVERED, CANCELLED }
public enum OrderType { SUR_PLACE, A_EMPORTER, LIVRAISON }

public class Zone
{
    public int Id { get; set; }
    [Required]
    public string Nom { get; set; } = string.Empty;
    public decimal FraisLivraison { get; set; }
}

public class Order
{
    public int Id { get; set; }
    public int? ClientId { get; set; }
    public int? ZoneId { get; set; }
    public DateTime DateCommande { get; set; } = DateTime.UtcNow;
    public OrderStatus Etat { get; set; } = OrderStatus.PENDING;
    public OrderType TypeCommande { get; set; }
    public decimal PrixTotal { get; set; }
    public int? LivreurId { get; set; }

    public User? Client { get; set; }
    public Zone? Zone { get; set; }
    public List<OrderDetail> Details { get; set; } = new();
}

public class OrderDetail
{
    public int Id { get; set; }
    public int CommandeId { get; set; }
    public int? ProductId { get; set; }
    public int? MenuId { get; set; }
    public int Quantite { get; set; }
    public decimal PrixUnitaire { get; set; }

    public Order? Commande { get; set; }
    public Product? Product { get; set; }
    public Menu? Menu { get; set; }
}
