using Microsoft.AspNetCore.Mvc;
using BrasilBurger.Web.Data;
using Microsoft.EntityFrameworkCore;
using System.Linq;
using System.Net.Http;
using System.Threading.Tasks;

namespace BrasilBurger.Web.Controllers
{
    public class DiagnosticController : Controller
    {
        private readonly AppDbContext _context;
        private readonly HttpClient _httpClient;

        public DiagnosticController(AppDbContext context)
        {
            _context = context;
            _httpClient = new HttpClient();
        }

        public async Task<IActionResult> CheckImages()
        {
            var burgers = await _context.Burgers
                .Select(b => new { b.Id, b.Nom, b.Image })
                .Take(10)
                .ToListAsync();

            var menus = await _context.Menus
                .Select(m => new { m.Id, m.Nom, m.Image })
                .Take(10)
                .ToListAsync();

            var results = new
            {
                Burgers = burgers.Select(b => new
                {
                    b.Id,
                    b.Nom,
                    ImageUrl = b.Image,
                    IsAccessible = CheckImageAccessibility(b.Image).Result
                }),
                Menus = menus.Select(m => new
                {
                    m.Id,
                    m.Nom,
                    ImageUrl = m.Image,
                    IsAccessible = CheckImageAccessibility(m.Image).Result
                })
            };

            return Json(results);
        }

        private async Task<bool> CheckImageAccessibility(string? imageUrl)
        {
            if (string.IsNullOrEmpty(imageUrl))
                return false;

            try
            {
                var response = await _httpClient.SendAsync(new HttpRequestMessage(HttpMethod.Head, imageUrl));
                return response.IsSuccessStatusCode;
            }
            catch
            {
                return false;
            }
        }
    }
}


