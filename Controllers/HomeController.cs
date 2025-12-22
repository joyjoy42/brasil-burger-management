using Microsoft.AspNetCore.Mvc;

namespace BrasilBurger.Web.Controllers
{
    public class HomeController : Controller
    {
        public IActionResult Index()
        {
            return RedirectToAction("Index", "Catalogue");
        }

        public IActionResult Error(int? statusCode = null)
        {
            if (statusCode.HasValue)
            {
                ViewBag.StatusCode = statusCode.Value;
                
                switch (statusCode.Value)
                {
                    case 400:
                        ViewBag.ErrorMessage = "Requête invalide. Veuillez vérifier les informations saisies.";
                        break;
                    case 404:
                        ViewBag.ErrorMessage = "Page non trouvée.";
                        break;
                    case 500:
                        ViewBag.ErrorMessage = "Erreur interne du serveur.";
                        break;
                    default:
                        ViewBag.ErrorMessage = "Une erreur est survenue.";
                        break;
                }
            }
            
            return View();
        }
    }
}
