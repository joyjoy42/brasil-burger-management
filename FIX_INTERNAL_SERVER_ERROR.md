# 🔧 Résolution Erreur "Internal Server Error" sur Render

## 🔍 Diagnostic de l'Erreur

L'erreur "Internal Server Error" (500) peut avoir plusieurs causes. Voici comment les identifier et les résoudre.

---

## 🎯 Causes Courantes et Solutions

### 1. ❌ Migrations Non Appliquées

**Symptôme** : Erreur 500 dès le chargement de la page

**Solution** :

**Option A : Via Render Shell**
1. Render Dashboard → Service → **"Shell"**
2. Exécutez :
   ```bash
   dotnet ef database update
   ```

**Option B : En Local**
```bash
dotnet ef database update --connection "Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"
```

### 2. ❌ Variables d'Environnement Manquantes ou Incorrectes

**Vérification dans Render Dashboard** :

1. Service → **"Environment"**
2. Vérifiez que toutes ces variables existent :

| Variable | Valeur Attendu |
|----------|---------------|
| `ASPNETCORE_ENVIRONMENT` | `Production` |
| `ASPNETCORE_URLS` | `http://0.0.0.0:10000` |
| `ConnectionStrings__DefaultConnection` | `Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true` |
| `Cloudinary__CloudName` | `dbkji1d1j` |
| `Cloudinary__ApiKey` | `166294258315442` |
| `Cloudinary__ApiSecret` | `9bpSi55tkiP5IZnwNpHrMuw-Qsc` |

**⚠️ Important** : Utilisez `__` (double underscore) pour les sections imbriquées :
- `ConnectionStrings__DefaultConnection` (pas `ConnectionStrings:DefaultConnection`)
- `Cloudinary__CloudName` (pas `Cloudinary:CloudName`)

### 3. ❌ Connexion Base de Données Échouée

**Vérification** :

1. **Logs Render** → Cherchez des erreurs comme :
   - "Unable to connect to database"
   - "Connection refused"
   - "SSL connection required"

2. **Test de Connexion** :
   - Vérifiez que Neon PostgreSQL est accessible
   - Vérifiez les identifiants dans les variables d'environnement
   - Vérifiez que le SSL Mode est `Require`

### 4. ❌ Erreur dans le Code

**Vérification des Logs** :

1. Render Dashboard → Service → **"Logs"**
2. Cherchez les erreurs en rouge
3. Les erreurs courantes :
   - `NullReferenceException`
   - `MissingMethodException`
   - `FileNotFoundException`

### 5. ❌ Problème avec Cloudinary

**Vérification** :

1. Vérifiez les identifiants Cloudinary dans les variables d'environnement
2. Vérifiez que votre compte Cloudinary est actif
3. Vérifiez les logs pour des erreurs Cloudinary

---

## 🔧 Étapes de Diagnostic

### Étape 1 : Vérifier les Logs

1. **Render Dashboard** → Service → **"Logs"**
2. **Cherchez les erreurs** en rouge
3. **Copiez les messages d'erreur** complets

### Étape 2 : Vérifier les Variables d'Environnement

1. Service → **"Environment"**
2. **Vérifiez chaque variable** (voir tableau ci-dessus)
3. **Corrigez** si nécessaire

### Étape 3 : Appliquer les Migrations

```bash
# Via Render Shell
dotnet ef database update
```

### Étape 4 : Redéployer

1. Service → **"Manual Deploy"** → **"Deploy latest commit"**
2. Attendez la fin du build
3. Testez à nouveau

---

## 🐛 Erreurs Spécifiques et Solutions

### Erreur : "Unable to connect to database"

**Solution** :
1. Vérifiez `ConnectionStrings__DefaultConnection` dans Render
2. Vérifiez que Neon PostgreSQL est accessible
3. Testez la connexion avec psql :
   ```bash
   psql 'postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech/neondb?sslmode=require'
   ```

### Erreur : "Table does not exist"

**Solution** :
```bash
dotnet ef database update
```

### Erreur : "Cloudinary error"

**Solution** :
1. Vérifiez les identifiants Cloudinary
2. Vérifiez que votre compte est actif
3. Vérifiez les limites de votre plan

### Erreur : "MissingMethodException" ou "FileNotFoundException"

**Solution** :
1. Vérifiez que toutes les dépendances sont dans `.csproj`
2. Redéployez l'application
3. Vérifiez les logs de build

---

## 📝 Checklist de Résolution

- [ ] Logs Render vérifiés
- [ ] Variables d'environnement vérifiées et correctes
- [ ] Migrations appliquées (`dotnet ef database update`)
- [ ] Connexion base de données testée
- [ ] Identifiants Cloudinary vérifiés
- [ ] Application redéployée
- [ ] Erreur résolue

---

## 🔗 Commandes Utiles

### Voir les Logs en Temps Réel

Render Dashboard → Service → **"Logs"** → **"Live"**

### Redéployer

Render Dashboard → Service → **"Manual Deploy"** → **"Deploy latest commit"**

### Tester la Connexion DB

```bash
# Via Render Shell
dotnet ef database update --verbose
```

---

## 💡 Solution Rapide

**Si vous ne trouvez pas la cause** :

1. **Vérifiez les logs** Render (erreurs en rouge)
2. **Appliquez les migrations** : `dotnet ef database update`
3. **Vérifiez les variables d'environnement** dans Render
4. **Redéployez** l'application

**Dans 90% des cas**, c'est soit :
- Migrations non appliquées
- Variables d'environnement incorrectes
- Connexion base de données échouée

---

**Date** : Décembre 2025

