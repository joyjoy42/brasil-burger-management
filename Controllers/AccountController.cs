using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Authentication;
using Microsoft.AspNetCore.Authentication.Cookies;
using System.Security.Claims;
using BrasilBurger.Web.Models.ViewModels;
using BrasilBurger.Web.Services;
using System;

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

            // Vérifier que l'utilisateur est bien authentifié
            if (User.Identity?.IsAuthenticated == false)
            {
                // Forcer la ré-authentification si nécessaire
                await HttpContext.SignInAsync(
                    CookieAuthenticationDefaults.AuthenticationScheme,
                    new ClaimsPrincipal(claimsIdentity),
                    authProperties);
            }

            TempData["SuccessMessage"] = $"Connexion réussie ! Bienvenue {client.Prenom} {client.Nom} ! Vous avez maintenant accès à toutes les fonctionnalités.";

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
            try
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

                // Vérifier que l'utilisateur est bien authentifié
                if (User.Identity?.IsAuthenticated == false)
                {
                    // Forcer la ré-authentification si nécessaire
                    await HttpContext.SignInAsync(
                        CookieAuthenticationDefaults.AuthenticationScheme,
                        new ClaimsPrincipal(claimsIdentity),
                        authProperties);
                }

                TempData["SuccessMessage"] = $"Inscription réussie ! Bienvenue {client.Prenom} {client.Nom} ! Vous avez maintenant accès à toutes les fonctionnalités.";
                
                // Redirection explicite vers le catalogue
                return Redirect("/Catalogue");
            }
            catch (Exception ex)
            {
                // Log l'erreur (vous pouvez utiliser ILogger ici)
                ModelState.AddModelError(string.Empty, $"Une erreur est survenue lors de l'inscription. Veuillez réessayer. Erreur: {ex.Message}");
                return View(model);
            }
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

        [HttpGet]
        public IActionResult ForgotPassword()
        {
            return View();
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ForgotPassword(ForgotPasswordViewModel model)
        {
            if (!ModelState.IsValid)
            {
                return View(model);
            }

            var token = await _clientService.GeneratePasswordResetTokenAsync(model.Email);
            
            // Always show success message for security (don't reveal if email exists)
            if (token != null)
            {
                // In production, send email with reset link
                // For now, we'll show the token in a message (not recommended for production)
                TempData["ResetToken"] = token;
                TempData["ResetEmail"] = model.Email;
                TempData["InfoMessage"] = $"Un token de réinitialisation a été généré. Utilisez-le pour réinitialiser votre mot de passe. (Token: {token})";
                return RedirectToAction("ResetPassword", new { email = model.Email, token = token });
            }
            else
            {
                // Still show success for security
                TempData["InfoMessage"] = "Si cet email existe, un lien de réinitialisation a été envoyé.";
                return View(model);
            }
        }

        [HttpGet]
        public IActionResult ResetPassword(string? email = null, string? token = null)
        {
            var model = new ResetPasswordViewModel
            {
                Email = email ?? "",
                Token = token ?? ""
            };

            // Check if token is in TempData (from ForgotPassword redirect)
            if (string.IsNullOrEmpty(token) && TempData["ResetToken"] != null)
            {
                model.Token = TempData["ResetToken"].ToString() ?? "";
                model.Email = TempData["ResetEmail"]?.ToString() ?? "";
            }

            return View(model);
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public async Task<IActionResult> ResetPassword(ResetPasswordViewModel model)
        {
            if (!ModelState.IsValid)
            {
                return View(model);
            }

            var success = await _clientService.ResetPasswordAsync(model.Email, model.Token, model.Password);

            if (success)
            {
                TempData["SuccessMessage"] = "Votre mot de passe a été réinitialisé avec succès. Vous pouvez maintenant vous connecter.";
                return RedirectToAction("Login");
            }
            else
            {
                ModelState.AddModelError(string.Empty, "Token invalide ou expiré. Veuillez demander un nouveau lien de réinitialisation.");
                return View(model);
            }
        }
    }
}

