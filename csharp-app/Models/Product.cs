using System.ComponentModel.DataAnnotations;

namespace BrasilBurgerClient.Models;

public enum ProductType { BURGER, COMPLEMENT }

public class Product
{
    public int Id { get; set; }
    [Required]
    public string Nom { get; set; } = string.Empty;
    public decimal? Prix { get; set; }
    public ProductType Type { get; set; }
    public string? Image { get; set; }
    public bool EstArchive { get; set; } = false;
}

public class Menu
{
    public int Id { get; set; }
    [Required]
    public string Nom { get; set; } = string.Empty;
    public string? Image { get; set; }
    public bool EstArchive { get; set; } = false;
    
    public List<MenuItem> Items { get; set; } = new();
}

public class MenuItem
{
    public int MenuId { get; set; }
    public int ProductId { get; set; }
    public int Quantite { get; set; } = 1;

    public Menu? Menu { get; set; }
    public Product? Product { get; set; }
}
