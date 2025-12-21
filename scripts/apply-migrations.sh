#!/bin/bash
# Script pour appliquer les migrations sur Render

echo "🔧 Application des migrations de base de données..."

# Connexion à la base de données Neon
CONNECTION_STRING="Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"

# Appliquer les migrations
dotnet ef database update --connection "$CONNECTION_STRING" --verbose

if [ $? -eq 0 ]; then
    echo "✅ Migrations appliquées avec succès !"
else
    echo "❌ Erreur lors de l'application des migrations"
    exit 1
fi

