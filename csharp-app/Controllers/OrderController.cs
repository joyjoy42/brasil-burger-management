using Microsoft.AspNetCore.Mvc;
using BrasilBurgerClient.Data;
using BrasilBurgerClient.Models;
using Microsoft.EntityFrameworkCore;

namespace BrasilBurgerClient.Controllers;

public class OrderController : Controller
{
    private readonly ApplicationDbContext _context;

    public OrderController(ApplicationDbContext context)
    {
        _context = context;
    }

    public async Task<IActionResult> Index()
    {
        var userId = HttpContext.Session.GetInt32("UserId");
        if (userId == null) return RedirectToAction("Login", "Auth");

        var orders = await _context.Orders
            .Where(o => o.ClientId == userId)
            .Include(o => o.Details)
                .ThenInclude(d => d.Product)
            .Include(o => o.Details)
                .ThenInclude(d => d.Menu)
            .OrderByDescending(o => o.DateCommande)
            .ToListAsync();

        return View(orders);
    }
}
