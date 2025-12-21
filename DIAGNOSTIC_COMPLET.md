# 🔍 Diagnostic Complet - Erreur 500 Internal Server Error

## 📋 Checklist de Diagnostic

### ✅ Étape 1 : Vérifier les Logs Render

**Action** :
1. Render Dashboard → Service → **"Logs"**
2. Cherchez les erreurs en **rouge**
3. **Copiez le message d'erreur complet**

**Erreurs courantes à chercher** :
- ❌ `Npgsql.NpgsqlException` → Problème connexion PostgreSQL
- ❌ `System.InvalidOperationException: No database provider has been configured` → Migrations non appliquées
- ❌ `Microsoft.EntityFrameworkCore.DbUpdateException` → Problème base de données
- ❌ `CloudinaryDotNet.Exceptions.CloudinaryException` → Problème Cloudinary
- ❌ `System.NullReferenceException` → Erreur dans le code

---

### ✅ Étape 2 : Vérifier les Variables d'Environnement

**Dans Render Dashboard** → Service → **"Environment"**

**Variables REQUISES** :

```bash
ASPNETCORE_ENVIRONMENT=Production
ASPNETCORE_URLS=http://0.0.0.0:10000
ConnectionStrings__DefaultConnection=Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true
Cloudinary__CloudName=dbkji1d1j
Cloudinary__ApiKey=166294258315442
Cloudinary__ApiSecret=9bpSi55tkiP5IZnwNpHrMuw-Qsc
```

**⚠️ IMPORTANT** :
- Utilisez `__` (double underscore) pour les sections imbriquées
- Pas d'espaces avant/après le `=`
- Valeurs entre guillemets si elles contiennent des espaces

---

### ✅ Étape 3 : Appliquer les Migrations

**Via Render Shell** :

```bash
dotnet ef database update
```

**Résultat attendu** :
```
Applying migration '20231201_InitialMigration'.
Done.
```

**Si erreur "No migrations found"** :
```bash
dotnet ef migrations add InitialMigration
dotnet ef database update
```

---

### ✅ Étape 4 : Vérifier la Connexion Base de Données

**Test de connexion** :

```bash
# Via Render Shell
psql 'postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech/neondb?sslmode=require'
```

**Ou vérifier les tables** :
```sql
\dt
```

---

### ✅ Étape 5 : Vérifier Cloudinary

**Test** :
1. Allez sur https://console.cloudinary.com
2. Vérifiez que votre compte est actif
3. Vérifiez les identifiants :
   - Cloud Name : `dbkji1d1j`
   - API Key : `166294258315442`
   - API Secret : (doit correspondre)

---

## 🎯 Solutions par Type d'Erreur

### Erreur : "No database provider has been configured"

**Cause** : Migrations non appliquées ou connexion DB incorrecte

**Solution** :
1. Vérifiez `ConnectionStrings__DefaultConnection` dans Render
2. Appliquez les migrations : `dotnet ef database update`

### Erreur : "Unable to connect to database"

**Cause** : Connexion PostgreSQL échouée

**Solution** :
1. Vérifiez les identifiants Neon dans Render
2. Vérifiez que Neon PostgreSQL est accessible
3. Testez la connexion avec psql

### Erreur : "Table does not exist"

**Cause** : Migrations non appliquées

**Solution** :
```bash
dotnet ef database update
```

### Erreur : "Cloudinary error"

**Cause** : Identifiants Cloudinary incorrects

**Solution** :
1. Vérifiez les variables `Cloudinary__*` dans Render
2. Vérifiez votre compte Cloudinary

### Erreur : "NullReferenceException"

**Cause** : Erreur dans le code

**Solution** :
1. Vérifiez les logs pour la ligne exacte
2. Vérifiez que toutes les dépendances sont présentes
3. Vérifiez les données dans la base

---

## 🔧 Actions Immédiates

### Si vous ne savez pas par où commencer :

1. **Vérifiez les logs Render** (priorité #1)
2. **Appliquez les migrations** : `dotnet ef database update`
3. **Vérifiez les variables d'environnement** dans Render
4. **Redéployez** : Manual Deploy → Deploy latest commit

---

## 📞 Partagez avec Moi

Pour que je puisse vous aider plus précisément, partagez :

1. **Message d'erreur exact** des logs Render
2. **Résultat de** `dotnet ef database update`
3. **Variables d'environnement** configurées (sans les mots de passe)

---

**Date** : Décembre 2025

