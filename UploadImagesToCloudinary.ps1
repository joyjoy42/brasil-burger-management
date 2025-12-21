# Script PowerShell pour uploader les images vers Cloudinary
# Usage: .\UploadImagesToCloudinary.ps1 -CloudName "votre_cloud_name" -ApiKey "votre_api_key" -ApiSecret "votre_api_secret"

param(
    [Parameter(Mandatory=$true)]
    [string]$CloudName,
    
    [Parameter(Mandatory=$true)]
    [string]$ApiKey,
    
    [Parameter(Mandatory=$true)]
    [string]$ApiSecret,
    
    [string]$ImagesFolder = "wwwroot\images",
    [string]$CloudinaryFolder = "brasil-burger"
)

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "  Upload Images vers Cloudinary" -ForegroundColor Green
Write-Host "========================================`n" -ForegroundColor Cyan

# Fonction pour uploader une image
function Upload-ImageToCloudinary {
    param(
        [string]$FilePath,
        [string]$PublicId
    )
    
    $timestamp = [Math]::Floor([decimal](Get-Date(Get-Date).ToUniversalTime()-uformat "%s"))
    $signature_string = "folder=$CloudinaryFolder&public_id=$PublicId&timestamp=$timestamp$ApiSecret"
    
    $signature = -join ((New-Object System.Security.Cryptography.SHA1Managed).ComputeHash(
        [System.Text.Encoding]::UTF8.GetBytes($signature_string)) | ForEach-Object { $_.ToString("x2") })
    
    $uri = "https://api.cloudinary.com/v1_1/$CloudName/image/upload"
    
    $form = @{
        file = Get-Item -Path $FilePath
        api_key = $ApiKey
        timestamp = $timestamp
        signature = $signature
        folder = $CloudinaryFolder
        public_id = $PublicId
    }
    
    try {
        $response = Invoke-RestMethod -Uri $uri -Method Post -Form $form
        return $response.secure_url
    }
    catch {
        Write-Host "Erreur lors de l'upload de $FilePath : $_" -ForegroundColor Red
        return $null
    }
}

# Vérifier que le dossier d'images existe
if (-not (Test-Path $ImagesFolder)) {
    Write-Host "Le dossier $ImagesFolder n'existe pas!" -ForegroundColor Red
    exit 1
}

# Obtenir toutes les images (jpg, jpeg, png)
$images = Get-ChildItem -Path $ImagesFolder -Include *.jpg,*.jpeg,*.png -File

if ($images.Count -eq 0) {
    Write-Host "Aucune image trouvée dans $ImagesFolder" -ForegroundColor Yellow
    exit 0
}

Write-Host "Trouvé $($images.Count) images à uploader`n" -ForegroundColor Yellow

# Dictionnaire pour stocker les mappages ancien chemin -> nouvelle URL
$urlMappings = @{}

# Upload de chaque image
$uploadedCount = 0
$failedCount = 0

foreach ($image in $images) {
    $fileName = $image.Name
    $fileNameWithoutExt = [System.IO.Path]::GetFileNameWithoutExtension($fileName)
    
    Write-Host "Upload de $fileName... " -NoNewline
    
    $cloudinaryUrl = Upload-ImageToCloudinary -FilePath $image.FullName -PublicId $fileNameWithoutExt
    
    if ($cloudinaryUrl) {
        Write-Host "✓" -ForegroundColor Green
        $oldPath = "/images/$fileName"
        $urlMappings[$oldPath] = $cloudinaryUrl
        $uploadedCount++
    }
    else {
        Write-Host "✗" -ForegroundColor Red
        $failedCount++
    }
    
    Start-Sleep -Milliseconds 500  # Pause pour éviter le rate limiting
}

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "Résumé de l'upload:" -ForegroundColor Yellow
Write-Host "  Images uploadées: $uploadedCount" -ForegroundColor Green
Write-Host "  Échecs: $failedCount" -ForegroundColor Red
Write-Host "========================================`n" -ForegroundColor Cyan

# Sauvegarder les mappages dans un fichier JSON
$mappingsJson = $urlMappings | ConvertTo-Json -Depth 10
$mappingsJson | Out-File -FilePath "cloudinary_mappings.json" -Encoding UTF8

Write-Host "Mappages sauvegardés dans cloudinary_mappings.json" -ForegroundColor Green

Write-Host "`nPROCHAINE ÉTAPE:" -ForegroundColor Yellow
Write-Host "Exécutez UpdateDatabaseUrls.ps1 pour mettre à jour la base de données" -ForegroundColor White

