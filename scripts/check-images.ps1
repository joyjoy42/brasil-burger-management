# Script PowerShell pour vérifier les URLs d'images dans la base de données et tester leur accessibilité

Write-Host "🔍 Vérification des images dans la base de données..." -ForegroundColor Cyan

# Chaîne de connexion PostgreSQL (à adapter selon votre configuration)
$connectionString = "Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"

# Si psql n'est pas disponible, on utilise une autre méthode
Write-Host "`n⚠️  Ce script nécessite psql (PostgreSQL client) installé." -ForegroundColor Yellow
Write-Host "`nPour vérifier les images manuellement :" -ForegroundColor Yellow
Write-Host "1. Connectez-vous à votre base de données Neon" -ForegroundColor White
Write-Host "2. Exécutez : SELECT id, nom, image FROM burgers LIMIT 10;" -ForegroundColor White
Write-Host "3. Exécutez : SELECT id, nom, image FROM menus LIMIT 10;" -ForegroundColor White

Write-Host "`n📋 URLs Cloudinary attendues :" -ForegroundColor Cyan
$expectedImages = @(
    "burger-classique.jpg",
    "cheeseburger.jpg",
    "menu-etudiant.png",
    "menu-poulet.png",
    "menu-tacos.png",
    "menu-famille.png"
)

foreach ($img in $expectedImages) {
    $url = "https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/$img"
    Write-Host "`nTest de : $url" -ForegroundColor Gray
    
    try {
        $response = Invoke-WebRequest -Uri $url -Method Head -TimeoutSec 5 -ErrorAction Stop
        if ($response.StatusCode -eq 200) {
            Write-Host "  ✅ Image accessible" -ForegroundColor Green
        } else {
            Write-Host "  ❌ Image non accessible (Status: $($response.StatusCode))" -ForegroundColor Red
        }
    } catch {
        Write-Host "  ❌ Image non accessible : $($_.Exception.Message)" -ForegroundColor Red
    }
}

Write-Host "`n💡 Solution :" -ForegroundColor Yellow
Write-Host "Si les images ne sont pas accessibles, vous devez :" -ForegroundColor White
Write-Host "1. Aller sur https://console.cloudinary.com" -ForegroundColor White
Write-Host "2. Uploader les images dans le dossier 'brasil-burger'" -ForegroundColor White
Write-Host "3. Ou utiliser des images placeholder temporaires" -ForegroundColor White


