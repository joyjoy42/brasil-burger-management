# Script to test different Cloudinary URL formats
# This helps identify the correct URL format for uploaded images

Write-Host "🔍 Testing Cloudinary URL Formats..." -ForegroundColor Cyan
Write-Host ""

$cloudName = "dbkji1d1j"
$folder = "brasil-burger"
$testImages = @(
    "burger-classique",
    "cheeseburger",
    "menu-etudiant",
    "category-all"
)

foreach ($imageName in $testImages) {
    Write-Host "Testing: $imageName" -ForegroundColor Yellow
    
    # Format 1: With .jpg extension
    $url1 = "https://res.cloudinary.com/$cloudName/image/upload/$folder/$imageName.jpg"
    Write-Host "  Format 1 (with .jpg): " -NoNewline
    try {
        $response = Invoke-WebRequest -Uri $url1 -Method Head -TimeoutSec 5 -ErrorAction Stop
        Write-Host "✅ $($response.StatusCode)" -ForegroundColor Green
        Write-Host "    ✅ CORRECT URL: $url1" -ForegroundColor Green
        continue
    } catch {
        Write-Host "❌ 404" -ForegroundColor Red
    }
    
    # Format 2: With .png extension
    $url2 = "https://res.cloudinary.com/$cloudName/image/upload/$folder/$imageName.png"
    Write-Host "  Format 2 (with .png): " -NoNewline
    try {
        $response = Invoke-WebRequest -Uri $url2 -Method Head -TimeoutSec 5 -ErrorAction Stop
        Write-Host "✅ $($response.StatusCode)" -ForegroundColor Green
        Write-Host "    ✅ CORRECT URL: $url2" -ForegroundColor Green
        continue
    } catch {
        Write-Host "❌ 404" -ForegroundColor Red
    }
    
    # Format 3: Without extension
    $url3 = "https://res.cloudinary.com/$cloudName/image/upload/$folder/$imageName"
    Write-Host "  Format 3 (no extension): " -NoNewline
    try {
        $response = Invoke-WebRequest -Uri $url3 -Method Head -TimeoutSec 5 -ErrorAction Stop
        Write-Host "✅ $($response.StatusCode)" -ForegroundColor Green
        Write-Host "    ✅ CORRECT URL: $url3" -ForegroundColor Green
        continue
    } catch {
        Write-Host "❌ 404" -ForegroundColor Red
    }
    
    # Format 4: With version number (auto)
    $url4 = "https://res.cloudinary.com/$cloudName/image/upload/v1/$folder/$imageName"
    Write-Host "  Format 4 (with version): " -NoNewline
    try {
        $response = Invoke-WebRequest -Uri $url4 -Method Head -TimeoutSec 5 -ErrorAction Stop
        Write-Host "✅ $($response.StatusCode)" -ForegroundColor Green
        Write-Host "    ✅ CORRECT URL: $url4" -ForegroundColor Green
        continue
    } catch {
        Write-Host "❌ 404" -ForegroundColor Red
    }
    
    Write-Host "  ❌ None of the formats worked for $imageName" -ForegroundColor Red
    Write-Host ""
}

Write-Host ""
Write-Host "💡 How to find the correct URL in Cloudinary:" -ForegroundColor Cyan
Write-Host "1. Go to https://console.cloudinary.com" -ForegroundColor White
Write-Host "2. Navigate to Media Library → brasil-burger folder" -ForegroundColor White
Write-Host "3. Click on an image" -ForegroundColor White
Write-Host "4. Look at the 'URL' field - that's the correct format" -ForegroundColor White
Write-Host "5. Copy the public_id from the image details" -ForegroundColor White
