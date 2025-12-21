using System.Collections.Generic;

namespace BrasilBurger.Web.Helpers
{
    /// <summary>
    /// Helper class pour générer les URLs Cloudinary
    /// </summary>
    public static class CloudinaryHelper
    {
        private static string? _cloudName;
        private static string? _baseUrl;

        /// <summary>
        /// Initialise le helper avec le Cloud Name de Cloudinary
        /// </summary>
        public static void Initialize(string cloudName)
        {
            _cloudName = cloudName;
            _baseUrl = $"https://res.cloudinary.com/{cloudName}/image/upload/brasil-burger";
        }

        /// <summary>
        /// Obtient l'URL complète d'une image sur Cloudinary
        /// </summary>
        public static string GetImageUrl(string fileName)
        {
            if (string.IsNullOrEmpty(_baseUrl))
            {
                // Fallback vers les images locales si Cloudinary n'est pas configuré
                return $"/images/{fileName}";
            }

            return $"{_baseUrl}/{fileName}";
        }

        /// <summary>
        /// Obtient l'URL avec transformation (redimensionnement)
        /// </summary>
        public static string GetImageUrl(string fileName, int? width = null, int? height = null, string? crop = null)
        {
            if (string.IsNullOrEmpty(_cloudName))
            {
                return $"/images/{fileName}";
            }

            var transformations = new List<string>();
            
            if (width.HasValue)
                transformations.Add($"w_{width}");
            
            if (height.HasValue)
                transformations.Add($"h_{height}");
            
            if (!string.IsNullOrEmpty(crop))
                transformations.Add($"c_{crop}");

            var transform = transformations.Count > 0 ? $"/{string.Join(",", transformations)}" : "";
            
            return $"https://res.cloudinary.com/{_cloudName}/image/upload{transform}/brasil-burger/{fileName}";
        }

        /// <summary>
        /// URLs prédéfinies pour les transformations communes
        /// </summary>
        public static class Transformations
        {
            public static string Thumbnail(string fileName) => GetImageUrl(fileName, 150, 150, "thumb");
            public static string Card(string fileName) => GetImageUrl(fileName, 300, 200, "fill");
            public static string Large(string fileName) => GetImageUrl(fileName, 800, null, "scale");
            public static string Hero(string fileName) => GetImageUrl(fileName, 1200, 600, "fill");
        }
    }
}

