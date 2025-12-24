# 🔧 Résolution - Images Ne S'Affichent Pas

## 🔍 Diagnostic

Les images ne s'affichent pas dans l'application. Voici comment diagnostiquer et résoudre le problème.

---

## 🎯 Causes Possibles

### 1. Images Non Uploadées sur Cloudinary

Les URLs dans la base de données pointent vers Cloudinary, mais les images peuvent ne pas être uploadées.

**URLs attendues** :
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique.jpg
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/menu-etudiant.png
```

### 2. Noms d'Images Incorrects

Les noms dans la base de données peuvent ne pas correspondre aux noms réels sur Cloudinary.

### 3. Problème de CORS ou de Sécurité

Les images Cloudinary peuvent être bloquées par le navigateur.

---

## ✅ Solutions

### Solution 1 : Vérifier les Images sur Cloudinary

1. **Allez sur** : https://console.cloudinary.com
2. **Connectez-vous** avec vos identifiants
3. **Media Library** → Cherchez le dossier `brasil-burger`
4. **Vérifiez** que toutes les images existent :
   - `burger-classique.jpg`
   - `cheeseburger.jpg`
   - `menu-etudiant.png`
   - `menu-poulet.png`
   - etc.

### Solution 2 : Uploader les Images Manquantes

Si des images manquent :

1. **Cloudinary Dashboard** → **Media Library**
2. **Upload** → Sélectionnez les images depuis `wwwroot/images/`
3. **Folder** : `brasil-burger`
4. **Upload**

### Solution 3 : Vérifier les URLs dans la Base de Données

**Via Render Shell** ou **psql** :

```sql
-- Vérifier les URLs des burgers
SELECT id, nom, image FROM burgers LIMIT 10;

-- Vérifier les URLs des menus
SELECT id, nom, image FROM menus LIMIT 10;
```

**URLs correctes** doivent commencer par :
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/
```

### Solution 4 : Tester une URL Cloudinary

**Testez directement** dans le navigateur :
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique.jpg
```

Si l'image s'affiche → Le problème est dans l'application  
Si l'image ne s'affiche pas → L'image n'existe pas sur Cloudinary

---

## 🔧 Correction dans le Code

### Option 1 : Ajouter un Helper pour les Images

Créer un helper qui vérifie si l'image existe et utilise un fallback :

```csharp
public static string GetImageUrl(string? imageUrl, string defaultImage = "/images/default-burger.png")
{
    if (string.IsNullOrEmpty(imageUrl))
        return defaultImage;
    
    // Si c'est déjà une URL complète, la retourner
    if (imageUrl.StartsWith("http"))
        return imageUrl;
    
    // Sinon, construire l'URL Cloudinary
    return $"https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/{imageUrl}";
}
```

### Option 2 : Vérifier les Images dans les Vues

Les vues utilisent déjà `onerror` pour afficher un placeholder si l'image échoue, mais on peut améliorer :

```html
<img src="@(Model.Burger.Image ?? "/images/default-burger.png")" 
     alt="@Model.Burger.Nom" 
     onerror="this.onerror=null; this.src='https://via.placeholder.com/300x200?text=@Model.Burger.Nom'" />
```

---

## 📝 Checklist de Vérification

- [ ] Images uploadées sur Cloudinary dans le dossier `brasil-burger`
- [ ] Noms des images correspondent à ceux dans la base de données
- [ ] URLs dans la base de données sont complètes (commencent par `https://`)
- [ ] Test d'une URL Cloudinary dans le navigateur fonctionne
- [ ] Console du navigateur ne montre pas d'erreurs 404 pour les images
- [ ] Configuration Cloudinary correcte dans `appsettings.json` ou variables d'environnement

---

## 🚀 Action Immédiate

### Étape 1 : Vérifier Cloudinary

1. **Cloudinary Dashboard** : https://console.cloudinary.com
2. **Media Library** → Dossier `brasil-burger`
3. **Liste des images** présentes

### Étape 2 : Comparer avec la Base de Données

**Exécutez** :
```sql
SELECT nom, image FROM burgers WHERE image IS NOT NULL LIMIT 5;
```

**Comparez** les noms d'images avec ceux sur Cloudinary.

### Étape 3 : Uploader les Images Manquantes

Si des images manquent, uploadez-les depuis `wwwroot/images/` vers Cloudinary.

---

## 💡 Solution Rapide

**Si vous voulez utiliser les images locales en attendant** :

1. **Modifiez** `Program.cs` pour utiliser les chemins locaux :
```csharp
var imageBase = "/images"; // Au lieu de cloudinaryBase
```

2. **Ou** uploadez toutes les images sur Cloudinary et mettez à jour la base de données.

---

**Date** : Décembre 2025


