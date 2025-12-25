using BrasilBurger.Web.Models.Entities;
using BrasilBurger.Web.Models.ViewModels;

namespace BrasilBurger.Web.Services
{
    public interface IClientService
    {
        Task<Client?> RegisterAsync(RegisterViewModel model);
        Task<Client?> LoginAsync(string email, string password);
        Task<Client?> GetClientByIdAsync(int id);
        Task<Client?> GetClientByEmailAsync(string email);
        bool VerifyPassword(string password, string hashedPassword);
        string HashPassword(string password);
        Task<string?> GeneratePasswordResetTokenAsync(string email);
        Task<bool> ResetPasswordAsync(string email, string token, string newPassword);
    }
}