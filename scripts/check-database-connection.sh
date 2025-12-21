#!/bin/bash
# Script pour tester la connexion à la base de données

echo "🔍 Test de connexion à la base de données Neon PostgreSQL..."

CONNECTION_STRING="Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"

# Test avec psql (si disponible)
if command -v psql &> /dev/null; then
    echo "Test avec psql..."
    psql "$CONNECTION_STRING" -c "SELECT version();"
else
    echo "psql non disponible. Test avec dotnet ef..."
    dotnet ef database update --connection "$CONNECTION_STRING" --dry-run
fi

echo "✅ Test terminé"

