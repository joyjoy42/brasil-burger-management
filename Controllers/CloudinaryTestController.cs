using Microsoft.AspNetCore.Mvc;
using System.Net.Http;
using System.Threading.Tasks;

namespace BrasilBurger.Web.Controllers
{
    public class CloudinaryTestController : Controller
    {
        private readonly HttpClient _httpClient;

        public CloudinaryTestController()
        {
            _httpClient = new HttpClient();
        }

        /// <summary>
        /// Test different Cloudinary URL formats to find the correct one
        /// </summary>
        public async Task<IActionResult> TestUrls()
        {
            var cloudName = "dbkji1d1j";
            var folder = "brasil-burger";
            var testImages = new[]
            {
                "burger-classique",
                "burger-classique.jpg",
                "menu-etudiant",
                "menu-etudiant.png",
                "category-all",
                "category-all.png"
            };

            var results = new List<object>();

            foreach (var imageName in testImages)
            {
                var urlVariations = new[]
                {
                    $"https://res.cloudinary.com/{cloudName}/image/upload/{folder}/{imageName}",
                    $"https://res.cloudinary.com/{cloudName}/image/upload/v1/{folder}/{imageName}",
                    $"https://res.cloudinary.com/{cloudName}/image/upload/{imageName}",
                    $"https://res.cloudinary.com/{cloudName}/image/upload/v1/{imageName}"
                };

                foreach (var url in urlVariations)
                {
                    try
                    {
                        var response = await _httpClient.SendAsync(new HttpRequestMessage(HttpMethod.Head, url));
                        if (response.IsSuccessStatusCode)
                        {
                            results.Add(new
                            {
                                Image = imageName,
                                Url = url,
                                Status = "✅ Accessible",
                                StatusCode = (int)response.StatusCode
                            });
                            break; // Found working URL, no need to test others
                        }
                    }
                    catch
                    {
                        // Continue to next variation
                    }
                }
            }

            return Json(new
            {
                Message = "Test results for Cloudinary URLs",
                Results = results,
                Note = "If no results, check Cloudinary dashboard for actual public_id format"
            });
        }

        /// <summary>
        /// Instructions for finding the correct URL format
        /// </summary>
        public IActionResult Instructions()
        {
            return View();
        }
    }
}


