using BrasilBurger.Web.Data;
using BrasilBurger.Web.Models.Entities;
using BrasilBurger.Web.Models.ViewModels;
using Microsoft.EntityFrameworkCore;
using System.Security.Cryptography;
using System.Text;
using System.Collections.Concurrent;

namespace BrasilBurger.Web.Services
{
    public class ClientService : IClientService
    {
        private readonly AppDbContext _context;
        // In-memory storage for reset tokens (in production, use distributed cache or database)
        private static readonly ConcurrentDictionary<string, (string Token, DateTime Expiry)> _resetTokens = new();

        public ClientService(AppDbContext context)
        {
            _context = context;
        }

        public async Task<Client?> RegisterAsync(RegisterViewModel model)
        {
            // Check if email already exists
            if (await _context.Clients.AnyAsync(c => c.Email == model.Email))
            {
                return null; // Email already exists
            }

            var client = new Client
            {
                Nom = model.Nom,
                Prenom = model.Prenom,
                Email = model.Email,
                Telephone = model.Telephone,
                Password = HashPassword(model.Password),
                Adresse = model.Adresse,
                CreatedAt = DateTime.Now
            };

            _context.Clients.Add(client);
            await _context.SaveChangesAsync();

            return client;
        }

        public async Task<Client?> LoginAsync(string email, string password)
        {
            var client = await _context.Clients
                .FirstOrDefaultAsync(c => c.Email == email);

            if (client == null)
                return null;

            if (!VerifyPassword(password, client.Password))
                return null;

            return client;
        }

        public async Task<Client?> GetClientByIdAsync(int id)
        {
            return await _context.Clients.FindAsync(id);
        }

        public async Task<Client?> GetClientByEmailAsync(string email)
        {
            return await _context.Clients
                .FirstOrDefaultAsync(c => c.Email == email);
        }

        public bool VerifyPassword(string password, string hashedPassword)
        {
            // Simple hash verification (SHA256)
            // In production, consider using BCrypt or ASP.NET Core Identity
            var hashOfInput = HashPassword(password);
            return hashOfInput == hashedPassword;
        }

        public string HashPassword(string password)
        {
            // Simple SHA256 hashing
            // In production, consider using BCrypt or ASP.NET Core Identity
            using (var sha256 = SHA256.Create())
            {
                var hashedBytes = sha256.ComputeHash(Encoding.UTF8.GetBytes(password));
                return Convert.ToBase64String(hashedBytes);
            }
        }

        public async Task<string?> GeneratePasswordResetTokenAsync(string email)
        {
            var client = await GetClientByEmailAsync(email);
            if (client == null)
                return null;

            // Generate a secure token
            var tokenBytes = new byte[32];
            using (var rng = RandomNumberGenerator.Create())
            {
                rng.GetBytes(tokenBytes);
            }
            var token = Convert.ToBase64String(tokenBytes).Replace("+", "-").Replace("/", "_").TrimEnd('=');

            // Store token with 1 hour expiry
            var expiry = DateTime.UtcNow.AddHours(1);
            _resetTokens[email] = (token, expiry);

            // Clean up expired tokens
            CleanupExpiredTokens();

            return token;
        }

        public async Task<bool> ResetPasswordAsync(string email, string token, string newPassword)
        {
            // Verify token
            if (!_resetTokens.TryGetValue(email, out var tokenData))
                return false;

            if (tokenData.Token != token || tokenData.Expiry < DateTime.UtcNow)
            {
                _resetTokens.TryRemove(email, out _);
                return false;
            }

            // Get client and update password
            var client = await GetClientByEmailAsync(email);
            if (client == null)
                return false;

            client.Password = HashPassword(newPassword);
            await _context.SaveChangesAsync();

            // Remove used token
            _resetTokens.TryRemove(email, out _);

            return true;
        }

        private void CleanupExpiredTokens()
        {
            var expiredKeys = _resetTokens
                .Where(kvp => kvp.Value.Expiry < DateTime.UtcNow)
                .Select(kvp => kvp.Key)
                .ToList();

            foreach (var key in expiredKeys)
            {
                _resetTokens.TryRemove(key, out _);
            }
        }
    }
}