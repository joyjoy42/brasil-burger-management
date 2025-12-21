# Script pour mettre à jour les URLs d'images dans la base de données
# Usage: .\UpdateDatabaseWithCloudinaryUrls.ps1

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  Mise à jour Base de Données" -ForegroundColor Green
Write-Host "========================================`n" -ForegroundColor Cyan

# Vérifier que le fichier de mappings existe
if (-not (Test-Path "cloudinary_mappings.json")) {
    Write-Host "Le fichier cloudinary_mappings.json n'existe pas!" -ForegroundColor Red
    Write-Host "Veuillez d'abord exécuter UploadImagesToCloudinary.ps1" -ForegroundColor Yellow
    exit 1
}

# Charger les mappages
$mappings = Get-Content "cloudinary_mappings.json" | ConvertFrom-Json

Write-Host "Chargé $($mappings.PSObject.Properties.Count) mappages d'URLs`n" -ForegroundColor Yellow

# Supprimer l'ancienne base de données
if (Test-Path "brasil_burger.db") {
    Remove-Item "brasil_burger.db" -Force
    Write-Host "Ancienne base de données supprimée" -ForegroundColor Yellow
}

# Créer un fichier temporaire pour les nouveaux URLs
$cloudinaryUrlsScript = @"
// URLS CLOUDINARY - Généré automatiquement
// Ce fichier contient les URLs Cloudinary pour toutes les images

namespace BrasilBurger.Web.Data
{
    public static class CloudinaryUrls
    {
        // Burgers
"@

foreach ($property in $mappings.PSObject.Properties) {
    $oldPath = $property.Name
    $newUrl = $property.Value
    $varName = ($oldPath -replace "/images/", "" -replace "\.", "_" -replace "-", "_").ToUpper()
    $cloudinaryUrlsScript += "`n        public const string $varName = `"$newUrl`";"
}

$cloudinaryUrlsScript += @"

    }
}
"@

$cloudinaryUrlsScript | Out-File -FilePath "Data\CloudinaryUrls.cs" -Encoding UTF8

Write-Host "✓ Fichier CloudinaryUrls.cs créé" -ForegroundColor Green
Write-Host "`nPROCHAINE ÉTAPE:" -ForegroundColor Yellow
Write-Host "1. Redémarrez l'application" -ForegroundColor White
Write-Host "2. La base de données sera recréée avec les URLs Cloudinary" -ForegroundColor White
Write-Host "`nNote: Vous devez mettre à jour Program.cs pour utiliser les URLs Cloudinary" -ForegroundColor Yellow

