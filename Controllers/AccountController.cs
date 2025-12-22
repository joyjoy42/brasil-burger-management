using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authentication.Cookies;
using System.Security.Claims;
using BrasilBurger.Web.Models.ViewModels;
using BrasilBurger.Web.Services;

namespace BrasilBurger.Web.Controllers
{
    public class AccountController : Controller
    {
        private readonly IClientService _clientService;

        public AccountController(IClientService clientService)
        {
            _clientService = clientService;
        }

        [HttpGet]
        public IActionResult Login(string? returnUrl = null)
        {
            ViewData["ReturnUrl"] = returnUrl;
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Login(LoginViewModel model, string? returnUrl = null)
        {
            if (!ModelState.IsValid)
            {
                return View(model);
            }

            var client = await _clientService.LoginAsync(model.Email, model.Password);

            if (client == null)
            {
                ModelState.AddModelError(string.Empty, "Email ou mot de passe incorrect");
                return View(model);
            }

            // Create claims
            var claims = new List<Claim>
            {
                new Claim(ClaimTypes.NameIdentifier, client.Id.ToString()),
                new Claim(ClaimTypes.Name, $"{client.Prenom} {client.Nom}"),
                new Claim(ClaimTypes.Email, client.Email)
            };

            var claimsIdentity = new ClaimsIdentity(claims, CookieAuthenticationDefaults.AuthenticationScheme);
            var authProperties = new AuthenticationProperties
            {
                IsPersistent = model.RememberMe,
                ExpiresUtc = model.RememberMe ? DateTimeOffset.UtcNow.AddDays(30) : null
            };

            await HttpContext.SignInAsync(
                CookieAuthenticationDefaults.AuthenticationScheme,
                new ClaimsPrincipal(claimsIdentity),
                authProperties);

            if (!string.IsNullOrEmpty(returnUrl) && Url.IsLocalUrl(returnUrl))
            {
                return Redirect(returnUrl);
            }

            return RedirectToAction("Index", "Catalogue");
        }

        [HttpGet]
        public IActionResult Register()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Register(RegisterViewModel model)
        {
            if (!ModelState.IsValid)
            {
                return View(model);
            }

            // Check if email already exists
            var existingClient = await _clientService.GetClientByEmailAsync(model.Email);
            if (existingClient != null)
            {
                ModelState.AddModelError(nameof(model.Email), "Cet email est déjà utilisé");
                return View(model);
            }

            var client = await _clientService.RegisterAsync(model);

            if (client == null)
            {
                ModelState.AddModelError(string.Empty, "Une erreur est survenue lors de l'inscription");
                return View(model);
            }

            // Auto-login after registration
            var claims = new List<Claim>
            {
                new Claim(ClaimTypes.NameIdentifier, client.Id.ToString()),
                new Claim(ClaimTypes.Name, $"{client.Prenom} {client.Nom}"),
                new Claim(ClaimTypes.Email, client.Email)
            };

            var claimsIdentity = new ClaimsIdentity(claims, CookieAuthenticationDefaults.AuthenticationScheme);
            var authProperties = new AuthenticationProperties
            {
                IsPersistent = true,
                ExpiresUtc = DateTimeOffset.UtcNow.AddDays(30)
            };

            await HttpContext.SignInAsync(
                CookieAuthenticationDefaults.AuthenticationScheme,
                new ClaimsPrincipal(claimsIdentity),
                authProperties);

            TempData["SuccessMessage"] = "Inscription réussie ! Bienvenue !";
            return RedirectToAction("Index", "Catalogue");
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> Logout()
        {
            await HttpContext.SignOutAsync(CookieAuthenticationDefaults.AuthenticationScheme);
            return RedirectToAction("Index", "Catalogue");
        }

        [HttpGet]
        public IActionResult AccessDenied()
        {
            return View();
        }
    }
}

