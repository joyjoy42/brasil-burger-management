# 🚀 Guide Rapide : Migration vers Cloudinary

## Option Recommandée : Upload Manuel (Plus Simple)

### ✅ Étape 1 : Créer un compte Cloudinary
1. Allez sur https://cloudinary.com/users/register/free
2. Créez un compte gratuit
3. Notez vos credentials du Dashboard :
   - **Cloud Name** (ex: `dab123xyz`)
   - **API Key** (ex: `123456789012345`)
   - **API Secret** (ex: `abc123xyz...`)

### ✅ Étape 2 : Uploader vos images
1. Connectez-vous à Cloudinary
2. Allez dans **Media Library**
3. Créez un nouveau dossier : `brasil-burger`
4. Uploadez TOUTES les images du dossier `wwwroot/images/` :
   - burger-classique.jpg
   - cheeseburger.jpg
   - poulet-1.png
   - poulet-2.png
   - wings-bbq.png
   - wings-epice.png
   - nuggets.png
   - ... (voir liste complète dans CLOUDINARY_GUIDE_COMPLET.md)

### ✅ Étape 3 : Configurer appsettings.json

Ouvrez `appsettings.json` et remplacez :

```json
"Cloudinary": {
  "CloudName": "dab123xyz",          ← Votre Cloud Name ici
  "ApiKey": "123456789012345",       ← Votre API Key ici
  "ApiSecret": "abc123xyz..."        ← Votre API Secret ici
}
```

### ✅ Étape 4 : Mettre à jour Program.cs

**Option A : Utiliser CloudinaryHelper (Recommandé)**

1. Ajoutez en haut de Program.cs :
```csharp
using BrasilBurger.Web.Helpers;
```

2. Après la ligne `var builder = WebApplication.CreateBuilder(args);`, ajoutez :
```csharp
// Initialiser CloudinaryHelper
var cloudName = builder.Configuration["Cloudinary:CloudName"];
if (!string.IsNullOrEmpty(cloudName))
{
    CloudinaryHelper.Initialize(cloudName);
}
```

3. Dans le seed, remplacez chaque `/images/...` par :
```csharp
// AVANT
Image = "/images/burger-classique.jpg"

// APRÈS
Image = CloudinaryHelper.GetImageUrl("burger-classique.jpg")
```

**Option B : Utiliser les URLs directement (Plus Simple)**

Remplacez simplement dans le seed :
```csharp
// AVANT
Image = "/images/burger-classique.jpg"

// APRÈS (remplacez "dab123xyz" par votre Cloud Name)
Image = "https://res.cloudinary.com/dab123xyz/image/upload/brasil-burger/burger-classique.jpg"
```

### ✅ Étape 5 : Recréer la base de données

Exécutez dans PowerShell :
```powershell
# Supprimer l'ancienne base
Remove-Item "brasil_burger.db" -Force

# Redémarrer l'application
dotnet run --project BrasilBurger.Web.csproj
```

---

## 🎯 Exemple Complet de Remplacement

### AVANT (Images locales)
```csharp
var burgers = new[]
{
    new Burger { 
        Nom = "Burger Classique", 
        Prix = 2500m, 
        Image = "/images/burger-classique.jpg" 
    }
};
```

### APRÈS (Cloudinary)
```csharp
var burgers = new[]
{
    new Burger { 
        Nom = "Burger Classique", 
        Prix = 2500m, 
        Image = "https://res.cloudinary.com/dab123xyz/image/upload/brasil-burger/burger-classique.jpg" 
    }
};
```

---

## 📝 Liste de Remplacement

Voici la liste complète des remplacements à faire dans Program.cs :

| Avant (Local) | Après (Cloudinary) |
|---------------|-------------------|
| `/images/burger-classique.jpg` | `https://res.cloudinary.com/VOTRE_CLOUD/image/upload/brasil-burger/burger-classique.jpg` |
| `/images/cheeseburger.jpg` | `https://res.cloudinary.com/VOTRE_CLOUD/image/upload/brasil-burger/cheeseburger.jpg` |
| `/images/poulet-1.png` | `https://res.cloudinary.com/VOTRE_CLOUD/image/upload/brasil-burger/poulet-1.png` |
| ... | ... |

⚠️ **Important** : Remplacez `VOTRE_CLOUD` par votre Cloud Name réel !

---

## ✨ Avantages Immédiats

Après la migration :
- ✅ **Performance** : Images servies via CDN global ultra-rapide
- ✅ **Optimisation** : Compression automatique, format WebP
- ✅ **Scalabilité** : Plus de limite de taille ou de bande passante locale
- ✅ **Backup** : Images sauvegardées sur le cloud
- ✅ **Transformations** : Redimensionnement à la volée via URL

---

## 🛠️ Aide & Dépannage

### Problème : Images ne s'affichent pas
**Solution** : Vérifiez que :
1. Le dossier sur Cloudinary s'appelle bien `brasil-burger`
2. Les noms de fichiers correspondent exactement (sensible à la casse)
3. Votre Cloud Name est correct dans les URLs

### Problème : Certaines images manquent
**Solution** : Uploadez toutes les images de `wwwroot/images/` sur Cloudinary

### Problème : Erreur de connexion à Cloudinary
**Solution** : Vérifiez vos credentials dans `appsettings.json`

---

## 📞 Besoin d'aide ?

Consultez :
1. **CLOUDINARY_GUIDE_COMPLET.md** - Documentation détaillée
2. **EXEMPLE_PROGRAM_CS_CLOUDINARY.cs** - Exemples de code
3. Documentation Cloudinary : https://cloudinary.com/documentation

---

## 🎉 C'est tout !

Une fois ces étapes terminées, votre application Brasil Burger utilisera Cloudinary pour toutes les images !

**Temps estimé** : 15-20 minutes

**Difficulté** : Facile ⭐

