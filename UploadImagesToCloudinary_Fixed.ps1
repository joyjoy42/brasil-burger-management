# Script PowerShell pour uploader les images vers Cloudinary
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
        Write-Host "Erreur: $_" -ForegroundColor Red
        return $null
    }
}

# Verifier que le dossier existe
if (-not (Test-Path $ImagesFolder)) {
    Write-Host "Le dossier $ImagesFolder n'existe pas!" -ForegroundColor Red
    exit 1
}

# Obtenir toutes les images
$images = Get-ChildItem -Path $ImagesFolder -File | Where-Object { $_.Extension -match '\.(jpg|jpeg|png)$' } | Where-Object { $_.Name -notmatch '\.md$' }

if ($images.Count -eq 0) {
    Write-Host "Aucune image trouvee" -ForegroundColor Yellow
    exit 0
}

Write-Host "Trouve $($images.Count) images a uploader`n" -ForegroundColor Yellow

# Dictionnaire pour les mappages
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
        Write-Host "OK" -ForegroundColor Green
        $oldPath = "/images/$fileName"
        $urlMappings[$oldPath] = $cloudinaryUrl
        $uploadedCount++
    }
    else {
        Write-Host "ECHEC" -ForegroundColor Red
        $failedCount++
    }
    
    Start-Sleep -Milliseconds 500
}

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "Resume de l'upload:" -ForegroundColor Yellow
Write-Host "  Images uploadees: $uploadedCount" -ForegroundColor Green
Write-Host "  Echecs: $failedCount" -ForegroundColor Red
Write-Host "========================================`n" -ForegroundColor Cyan

# Sauvegarder les mappages
$mappingsJson = $urlMappings | ConvertTo-Json -Depth 10
$mappingsJson | Out-File -FilePath "cloudinary_mappings.json" -Encoding UTF8

Write-Host "Mappages sauvegardes dans cloudinary_mappings.json" -ForegroundColor Green

