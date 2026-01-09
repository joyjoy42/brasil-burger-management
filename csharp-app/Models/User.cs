using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace BrasilBurgerClient.Models;

public enum UserRole { CLIENT, GESTIONNAIRE, LIVREUR }

public class User
{
    public int Id { get; set; }
    [Required]
    public string Login { get; set; } = string.Empty;
    [Required]
    public string Password { get; set; } = string.Empty;
    public UserRole Role { get; set; }
    public string? Nom { get; set; }
    public string? Prenom { get; set; }
    public string? Telephone { get; set; }
    public string? Adresse { get; set; }
}
