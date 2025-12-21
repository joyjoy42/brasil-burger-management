using CloudinaryDotNet;
using CloudinaryDotNet.Actions;
using Microsoft.Extensions.Options;

namespace BrasilBurger.Web.Services
{
    public interface IImageService
    {
        Task<string?> UploadImageAsync(Stream imageStream, string fileName, string folder = "brasil-burger");
        string GetImageUrl(string publicId, int? width = null, int? height = null);
    }

    public class CloudinaryImageService : IImageService
    {
        private readonly Cloudinary _cloudinary;
        private readonly string _cloudName;

        public CloudinaryImageService(IOptions<CloudinarySettings> config)
        {
            var account = new Account(
                config.Value.CloudName,
                config.Value.ApiKey,
                config.Value.ApiSecret
            );
            
            _cloudinary = new Cloudinary(account);
            _cloudName = config.Value.CloudName;
        }

        public async Task<string?> UploadImageAsync(Stream imageStream, string fileName, string folder = "brasil-burger")
        {
            var uploadParams = new ImageUploadParams()
            {
                File = new FileDescription(fileName, imageStream),
                Folder = folder,
                PublicId = Path.GetFileNameWithoutExtension(fileName),
                Overwrite = true
            };

            var uploadResult = await _cloudinary.UploadAsync(uploadParams);

            if (uploadResult.StatusCode == System.Net.HttpStatusCode.OK)
            {
                return uploadResult.SecureUrl.ToString();
            }

            return null;
        }

        public string GetImageUrl(string publicId, int? width = null, int? height = null)
        {
            var url = $"https://res.cloudinary.com/{_cloudName}/image/upload";
            
            if (width.HasValue || height.HasValue)
            {
                var transformations = new List<string>();
                if (width.HasValue) transformations.Add($"w_{width}");
                if (height.HasValue) transformations.Add($"h_{height}");
                url += $"/{string.Join(",", transformations)}";
            }
            
            url += $"/{publicId}";
            
            return url;
        }
    }

    // Service pour les images locales (fallback)
    public class LocalImageService : IImageService
    {
        public Task<string?> UploadImageAsync(Stream imageStream, string fileName, string folder = "brasil-burger")
        {
            // Pour les images locales, on retourne juste le chemin
            return Task.FromResult<string?>($"/images/{fileName}");
        }

        public string GetImageUrl(string publicId, int? width = null, int? height = null)
        {
            return $"/images/{publicId}";
        }
    }
}

