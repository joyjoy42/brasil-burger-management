# 🚀 Guide de Déploiement C# sur Render.com

## 📋 Prérequis

- ✅ Compte Render.com (gratuit disponible)
- ✅ Projet C# sur GitHub (branche `csharp`)
- ✅ Base de données Neon PostgreSQL configurée
- ✅ Cloudinary configuré

---

## 🎯 Méthode 1 : Déploiement Automatique avec render.yaml (Recommandé)

### Étape 1 : Fichier render.yaml

Le fichier `render.yaml` est déjà créé à la racine du projet avec toute la configuration nécessaire.

### Étape 2 : Connecter Render à GitHub

1. **Connectez-vous à Render.com** : https://render.com
2. **Nouveau Web Service** : Cliquez sur "New +" → "Web Service"
3. **Connecter GitHub** :
   - Sélectionnez votre repository : `joyjoy42/brasil-burger-management`
   - Branche : `csharp`
   - Root Directory : (laisser vide ou `/`)

### Étape 3 : Configuration Automatique

Render détectera automatiquement le fichier `render.yaml` et utilisera la configuration.

### Étape 4 : Déployer

1. Cliquez sur "Create Web Service"
2. Render va :
   - Cloner le repository
   - Exécuter `dotnet restore && dotnet publish`
   - Démarrer l'application avec `dotnet ./publish/BrasilBurger.Web.dll`
   - Configurer les variables d'environnement

### Étape 5 : Appliquer les Migrations

Une fois déployé, vous devez appliquer les migrations de base de données :

**Option A : Via Render Shell**
1. Allez dans votre service → "Shell"
2. Exécutez :
   ```bash
   dotnet ef database update
   ```

**Option B : Via Command Line Locale**
```bash
# Avec la connexion à la base de données Neon
dotnet ef database update --connection "Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"
```

---

## 🎯 Méthode 2 : Déploiement Manuel (Sans render.yaml)

### Étape 1 : Créer un Web Service

1. **Render Dashboard** → "New +" → "Web Service"
2. **Connecter GitHub** :
   - Repository : `joyjoy42/brasil-burger-management`
   - Branch : `csharp`

### Étape 2 : Configuration

**Build Command :**
```bash
dotnet restore && dotnet publish -c Release -o ./publish
```

**Start Command :**
```bash
dotnet ./publish/BrasilBurger.Web.dll
```

**Environment :**
- `dotnet`

**Region :**
- `Oregon` (ou votre préférence)

### Étape 3 : Variables d'Environnement

Ajoutez ces variables dans "Environment" :

| Key | Value |
|-----|-------|
| `ASPNETCORE_ENVIRONMENT` | `Production` |
| `ASPNETCORE_URLS` | `http://0.0.0.0:10000` |
| `ConnectionStrings__DefaultConnection` | `Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true` |
| `Cloudinary__CloudName` | `dbkji1d1j` |
| `Cloudinary__ApiKey` | `166294258315442` |
| `Cloudinary__ApiSecret` | `9bpSi55tkiP5IZnwNpHrMuw-Qsc` |

**Note :** Dans Render, utilisez `__` (double underscore) pour les sections imbriquées dans appsettings.json.

### Étape 4 : Déployer

Cliquez sur "Create Web Service" et attendez le déploiement.

---

## ⚙️ Configuration Avancée

### Port Configuration

Render utilise automatiquement le port `10000` pour les applications .NET. Assurez-vous que votre `Program.cs` ou `appsettings.json` utilise :

```json
{
  "Kestrel": {
    "Endpoints": {
      "Http": {
        "Url": "http://0.0.0.0:10000"
      }
    }
  }
}
```

Ou dans `Program.cs` :
```csharp
app.Urls.Add("http://0.0.0.0:10000");
```

### Health Check

Le fichier `render.yaml` inclut un health check sur `/`. Assurez-vous que votre application a une route `/` qui répond.

### Build Optimizations

Pour accélérer le build, vous pouvez ajouter dans `render.yaml` :
```yaml
buildCommand: dotnet restore && dotnet publish -c Release -o ./publish --no-restore
```

---

## 🔧 Résolution de Problèmes

### Erreur : "Could not find a part of the path"

**Solution :** Vérifiez que le Root Directory est correct. Pour un projet à la racine, laissez vide.

### Erreur : "Database connection failed"

**Solution :** 
1. Vérifiez les variables d'environnement
2. Vérifiez que Neon PostgreSQL accepte les connexions depuis Render
3. Vérifiez le SSL Mode

### Erreur : "Migrations not applied"

**Solution :** Exécutez les migrations via Render Shell ou en local avec la connexion Neon.

### Build échoue

**Solution :**
1. Vérifiez les logs de build dans Render
2. Assurez-vous que toutes les dépendances sont dans `.csproj`
3. Vérifiez la version de .NET (doit être 6.0+)

---

## 📊 Monitoring

### Logs

- **Build Logs** : Voir dans l'onglet "Logs" pendant le build
- **Runtime Logs** : Voir dans l'onglet "Logs" après le déploiement

### Metrics

Render fournit des métriques :
- CPU Usage
- Memory Usage
- Request Count
- Response Time

---

## 🔒 Sécurité

### Variables d'Environnement

✅ **Ne jamais** committer les identifiants dans le code  
✅ Utiliser les variables d'environnement Render  
✅ Le fichier `render.yaml` avec identifiants ne doit pas être commité (optionnel)

### Recommandation

Pour plus de sécurité, vous pouvez :
1. Ne pas inclure les identifiants dans `render.yaml`
2. Les configurer manuellement dans Render Dashboard
3. Ajouter `render.yaml` dans `.gitignore` si vous y mettez les identifiants

---

## ✅ Checklist de Déploiement

- [ ] Fichier `render.yaml` créé (ou configuration manuelle)
- [ ] Repository GitHub connecté
- [ ] Variables d'environnement configurées
- [ ] Build command configuré
- [ ] Start command configuré
- [ ] Migrations appliquées
- [ ] Application accessible via l'URL Render
- [ ] Health check fonctionne
- [ ] Connexion base de données testée
- [ ] Cloudinary fonctionne

---

## 🎯 Après le Déploiement

### URL de l'Application

Une fois déployé, Render vous donnera une URL comme :
```
https://brasil-burger-csharp.onrender.com
```

### Mises à Jour Automatiques

Render déploie automatiquement à chaque push sur la branche `csharp` si l'auto-deploy est activé.

### Mise à Jour Manuelle

Pour forcer un redéploiement :
1. Allez dans votre service
2. Cliquez sur "Manual Deploy" → "Deploy latest commit"

---

## 📝 Notes Importantes

- ✅ **Plan Gratuit** : Le service peut "s'endormir" après 15 minutes d'inactivité
- ✅ **Premier Déploiement** : Peut prendre 5-10 minutes
- ✅ **Build Time** : Généralement 2-5 minutes
- ✅ **Cold Start** : Premier démarrage après sommeil peut prendre 30-60 secondes

---

## 🔗 Liens Utiles

- **Render Dashboard** : https://dashboard.render.com
- **Documentation Render** : https://render.com/docs
- **Documentation .NET** : https://render.com/docs/deploy-dotnet
- **Repository GitHub** : https://github.com/joyjoy42/brasil-burger-management

---

**Date de création** : Décembre 2025  
**Statut** : Prêt pour déploiement

