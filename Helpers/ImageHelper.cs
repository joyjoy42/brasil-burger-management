namespace BrasilBurger.Web.Helpers
{
    /// <summary>
    /// Helper pour gérer les URLs d'images (Cloudinary ou locales)
    /// </summary>
    public static class ImageHelper
    {
        private const string CloudinaryBase = "https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger";
        
        /// <summary>
        /// Obtient l'URL complète d'une image avec fallback vers placeholder
        /// </summary>
        public static string GetImageUrl(string? imageUrl, string defaultImage = "/images/default-burger.png", string? placeholderText = null)
        {
            // Si l'URL est vide ou null, utiliser un placeholder
            if (string.IsNullOrWhiteSpace(imageUrl))
            {
                if (!string.IsNullOrEmpty(placeholderText))
                {
                    var encodedText = System.Web.HttpUtility.UrlEncode(placeholderText);
                    return $"https://via.placeholder.com/300x200/FF6B35/FFFFFF?text={encodedText}";
                }
                return defaultImage;
            }
            
            // Si c'est déjà une URL complète (http/https), la retourner telle quelle
            if (imageUrl.StartsWith("http://") || imageUrl.StartsWith("https://"))
                return imageUrl;
            
            // Si c'est un chemin local (commence par /), le retourner tel quel
            if (imageUrl.StartsWith("/"))
                return imageUrl;
            
            // Sinon, construire l'URL Cloudinary complète
            return $"{CloudinaryBase}/{imageUrl}";
        }
        
        /// <summary>
        /// Vérifie si une URL est une URL Cloudinary
        /// </summary>
        public static bool IsCloudinaryUrl(string? url)
        {
            return !string.IsNullOrEmpty(url) && url.Contains("res.cloudinary.com");
        }
        
        /// <summary>
        /// Obtient l'URL avec transformation Cloudinary (redimensionnement)
        /// </summary>
        public static string GetImageUrlWithTransform(string? imageUrl, int? width = null, int? height = null, string defaultImage = "/images/default-burger.png")
        {
            var baseUrl = GetImageUrl(imageUrl, defaultImage);
            
            // Si ce n'est pas une URL Cloudinary, retourner telle quelle
            if (!IsCloudinaryUrl(baseUrl))
                return baseUrl;
            
            // Ajouter les transformations
            var transformations = new List<string>();
            if (width.HasValue) transformations.Add($"w_{width}");
            if (height.HasValue) transformations.Add($"h_{height}");
            
            if (transformations.Count > 0)
            {
                // Insérer les transformations avant le nom du fichier
                var parts = baseUrl.Split('/');
                var fileName = parts.Last();
                var basePath = string.Join("/", parts.Take(parts.Length - 1));
                return $"{basePath}/{string.Join(",", transformations)}/{fileName}";
            }
            
            return baseUrl;
        }
    }
}

