using Microsoft.AspNetCore.Mvc;
using BrasilBurgerClient.Data;
using BrasilBurgerClient.Models;
using Microsoft.EntityFrameworkCore;

namespace BrasilBurgerClient.Controllers;

public class AuthController : Controller
{
    private readonly ApplicationDbContext _context;

    public AuthController(ApplicationDbContext context)
    {
        _context = context;
    }

    [HttpGet]
    public IActionResult Login() => View();

    [HttpPost]
    public async Task<IActionResult> Login(string login, string password)
    {
        var user = await _context.Users.FirstOrDefaultAsync(u => u.Login == login && u.Password == password);
        if (user != null)
        {
            HttpContext.Session.SetInt32("UserId", user.Id);
            HttpContext.Session.SetString("UserName", user.Prenom ?? user.Login);
            return RedirectToAction("Index", "Home");
        }
        ViewBag.Error = "Identifiants incorrects";
        return View();
    }

    [HttpGet]
    public IActionResult Register() => View();

    [HttpPost]
    public async Task<IActionResult> Register(User user)
    {
        if (ModelState.IsValid)
        {
            user.Role = UserRole.CLIENT;
            _context.Users.Add(user);
            await _context.SaveChangesAsync();
            return RedirectToAction("Login");
        }
        return View(user);
    }

    public IActionResult Logout()
    {
        HttpContext.Session.Clear();
        return RedirectToAction("Login");
    }
}
