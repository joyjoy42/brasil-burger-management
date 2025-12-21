# Script PowerShell pour vérifier les variables d'environnement Render

Write-Host "🔍 Vérification des Variables d'Environnement Render" -ForegroundColor Cyan
Write-Host ""

$requiredVars = @{
    "ASPNETCORE_ENVIRONMENT" = "Production"
    "ASPNETCORE_URLS" = "http://0.0.0.0:10000"
    "ConnectionStrings__DefaultConnection" = "Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"
    "Cloudinary__CloudName" = "dbkji1d1j"
    "Cloudinary__ApiKey" = "166294258315442"
    "Cloudinary__ApiSecret" = "9bpSi55tkiP5IZnwNpHrMuw-Qsc"
}

Write-Host "Variables requises dans Render Dashboard :" -ForegroundColor Yellow
Write-Host ""

foreach ($var in $requiredVars.GetEnumerator()) {
    Write-Host "✅ $($var.Key)" -ForegroundColor Green
    Write-Host "   Valeur: $($var.Value)" -ForegroundColor Gray
    Write-Host ""
}

Write-Host "📝 Instructions :" -ForegroundColor Cyan
Write-Host "1. Allez sur https://dashboard.render.com"
Write-Host "2. Service → Environment"
Write-Host "3. Vérifiez que toutes ces variables existent"
Write-Host "4. Utilisez __ (double underscore) pour les sections imbriquées"
Write-Host ""

