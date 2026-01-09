using Microsoft.AspNetCore.Mvc;
using BrasilBurgerClient.Data;
using BrasilBurgerClient.Models;
using Microsoft.EntityFrameworkCore;

namespace BrasilBurgerClient.Controllers;

public class CatalogController : Controller
{
    private readonly ApplicationDbContext _context;

    public CatalogController(ApplicationDbContext context)
    {
        _context = context;
    }

    public async Task<IActionResult> Index()
    {
        var burgers = await _context.Products.Where(p => p.Type == ProductType.BURGER && !p.EstArchive).ToListAsync();
        var menus = await _context.Menus.Where(m => !m.EstArchive).ToListAsync();
        
        ViewBag.Burgers = burgers;
        ViewBag.Menus = menus;
        
        return View();
    }
}
