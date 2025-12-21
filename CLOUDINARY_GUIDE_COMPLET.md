# Guide Complet : Intégration Cloudinary

## 📋 Prérequis

1. Compte Cloudinary (gratuit) : https://cloudinary.com/users/register/free
2. Vos credentials Cloudinary (Cloud Name, API Key, API Secret)

---

## 🚀 Méthode 1 : Upload Automatique via Script PowerShell

### Étape 1 : Configurer vos credentials

Éditez `appsettings.json` et remplacez les valeurs :

```json
"Cloudinary": {
  "CloudName": "votre-cloud-name",    // Ex: dxxxxxxxx
  "ApiKey": "votre-api-key",           // Ex: 123456789012345
  "ApiSecret": "votre-api-secret"      // Ex: abcdefgh...
}
```

### Étape 2 : Exécuter le script d'upload

```powershell
.\UploadImagesToCloudinary.ps1 `
    -CloudName "votre-cloud-name" `
    -ApiKey "votre-api-key" `
    -ApiSecret "votre-api-secret"
```

Ce script va :
- ✅ Uploader toutes les images de `wwwroot/images/` vers Cloudinary
- ✅ Créer un dossier `brasil-burger` sur Cloudinary
- ✅ Générer un fichier `cloudinary_mappings.json` avec les nouveaux URLs

### Étape 3 : Mettre à jour la base de données

```powershell
.\UpdateDatabaseWithCloudinaryUrls.ps1
```

### Étape 4 : Redémarrer l'application

```powershell
dotnet run --project BrasilBurger.Web.csproj
```

---

## 🎯 Méthode 2 : Upload Manuel via Interface Cloudinary (RECOMMANDÉ)

### Étape 1 : Uploader vos images

1. Connectez-vous à https://cloudinary.com
2. Allez dans **Media Library**
3. Créez un dossier `brasil-burger`
4. Uploadez toutes les images de `wwwroot/images/`

### Étape 2 : Récupérer les URLs

Cloudinary génère automatiquement des URLs au format :
```
https://res.cloudinary.com/{cloud-name}/image/upload/brasil-burger/{filename}
```

### Étape 3 : Mettre à jour Program.cs

Remplacez `/images/` par les URLs Cloudinary. Exemple :

**AVANT :**
```csharp
Image = "/images/burger-classique.jpg"
```

**APRÈS :**
```csharp
Image = "https://res.cloudinary.com/votre-cloud-name/image/upload/brasil-burger/burger-classique.jpg"
```

### Étape 4 : Supprimer et recréer la base de données

```powershell
Remove-Item "brasil_burger.db" -Force
dotnet run --project BrasilBurger.Web.csproj
```

---

## 📝 Liste des images à uploader

Voici la liste complète des images à uploader sur Cloudinary :

### Images Principales
- burger-classique.jpg
- cheeseburger.jpg
- category-all.png
- category-burger.png
- category-menu.png
- logo.jpg

### Poulet & Grillades
- poulet-1.png
- poulet-2.png
- poulet-braise.png
- brochettes-poulet.png
- wings-bbq.png
- wings-epice.png
- nuggets.png

### Wraps & Tacos
- wrap-poulet.png
- wrap-boeuf.png
- tacos-simple.png
- tacos-xl.png

### Desserts
- glace.png
- donut.png
- crepe-sucree.png
- crepe-chocolat.png
- gateau.png

### Boissons
- jus-bissap.png
- jus-gingembre.png
- jus-ananas.png
- milkshake-vanille.png
- milkshake-chocolat.png
- milkshake-fraise.png

### Menus
- menu-etudiant.png
- menu-poulet.png
- menu-tacos.png
- menu-famille.png

---

## ✅ Avantages de Cloudinary

✨ **Performance**
- CDN global ultra-rapide
- Images servies depuis le serveur le plus proche de l'utilisateur

🎨 **Optimisation Automatique**
- Compression intelligente
- Format WebP automatique pour les navigateurs compatibles
- Lazy loading intégré

🔧 **Transformations à la volée**
```
# Redimensionner
https://res.cloudinary.com/.../w_300,h_200/image.jpg

# Ajouter des effets
https://res.cloudinary.com/.../e_blur:300/image.jpg

# Recadrer intelligent
https://res.cloudinary.com/.../c_thumb,g_face/image.jpg
```

💰 **Plan Gratuit Généreux**
- 25 GB de stockage
- 25 GB de bande passante/mois
- 25 000 transformations/mois

---

## 🔒 Sécurité

⚠️ **IMPORTANT** : Ne commitez jamais vos credentials dans Git !

Ajoutez à `.gitignore` :
```
appsettings.json
appsettings.*.json
cloudinary_mappings.json
```

Pour la production, utilisez des variables d'environnement :
```csharp
builder.Configuration["Cloudinary:CloudName"] = Environment.GetEnvironmentVariable("CLOUDINARY_CLOUD_NAME");
```

---

## 📞 Support

Si vous avez des questions :
1. Documentation Cloudinary : https://cloudinary.com/documentation
2. Support Cloudinary : https://support.cloudinary.com/
3. Package .NET : https://github.com/cloudinary/CloudinaryDotNet

---

## 🎯 Prochaines Étapes Recommandées

Après la migration vers Cloudinary, vous pouvez :

1. **Optimiser les images** : Utiliser les transformations Cloudinary pour différentes tailles
2. **Ajouter un admin panel** : Interface pour uploader de nouvelles images
3. **Implémenter le lazy loading** : Charger les images seulement quand nécessaire
4. **Utiliser les formats modernes** : WebP, AVIF automatiquement

---

## 📊 Exemple de Programme.cs avec Cloudinary

```csharp
// Configuration dans Program.cs
builder.Services.Configure<CloudinarySettings>(
    builder.Configuration.GetSection("Cloudinary"));
builder.Services.AddScoped<IImageService, CloudinaryImageService>();

// Utilisation dans le seed
var cloudName = builder.Configuration["Cloudinary:CloudName"];
var baseUrl = $"https://res.cloudinary.com/{cloudName}/image/upload/brasil-burger";

new Burger { 
    Nom = "Burger Classique", 
    Image = $"{baseUrl}/burger-classique.jpg" 
}
```

