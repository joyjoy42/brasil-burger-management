# 🚀 GUIDE : Upload Manuel vers Cloudinary (RECOMMANDÉ)

## Pourquoi l'upload manuel ?
- Plus simple et plus rapide
- Interface visuelle intuitive
- Pas de problèmes de compatibilité PowerShell
- Vous voyez directement vos images

## ✅ Étapes Simples

### 1. Connectez-vous à Cloudinary
- Allez sur : https://cloudinary.com/console
- Connectez-vous avec vos credentials

### 2. Créez le dossier
- Dans la barre latérale, cliquez sur **Media Library**
- Cliquez sur **Create Folder**
- Nommez le dossier : `brasil-burger`

### 3. Uploadez vos images
- Ouvrez le dossier `brasil-burger`
- Cliquez sur **Upload** (bouton bleu en haut à droite)
- Sélectionnez **Multiple files**
- Naviguez vers : `C:\Users\hp zion\Documents\brasil-burger-management\wwwroot\images`
- Sélectionnez TOUTES les images (Ctrl+A)
- Cliquez sur **Ouvrir**

⏱️ **Temps estimé** : 3-5 minutes pour uploader 32 images

### 4. Vérifiez l'upload
Une fois terminé, vous devriez voir vos 32 images dans le dossier `brasil-burger` :

**Images à vérifier (32 au total) :**
- brochettes-poulet.png
- burger-classique.jpg
- category-all.png
- category-burger.png
- category-menu.png
- cheeseburger.jpg
- crepe-chocolat.png
- crepe-sucree.png
- donut.png
- gateau.png
- glace.png
- jus-ananas.png
- jus-bissap.png
- jus-gingembre.png
- logo.jpg
- menu-etudiant.png
- menu-famille.png
- menu-poulet.png
- menu-tacos.png
- milkshake-chocolat.png
- milkshake-fraise.png
- milkshake-vanille.png
- nuggets.png
- poulet-1.png
- poulet-2.png
- poulet-braise.png
- tacos-simple.png
- tacos-xl.png
- wings-bbq.png
- wings-epice.png
- wrap-boeuf.png
- wrap-poulet.png

### 5. Quand c'est fait
Revenez ici et dites-moi simplement : **"Upload terminé"**

Je mettrai automatiquement à jour votre fichier `Program.cs` avec toutes les URLs Cloudinary !

---

## 💡 URLs Cloudinary

Vos images seront accessibles à cette adresse :
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/NOM_IMAGE
```

Par exemple :
- burger-classique.jpg → `https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique.jpg`
- logo.jpg → `https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/logo.jpg`

---

## 🎯 Alternative : Upload Direct depuis mon code

Si vous préférez, je peux aussi utiliser le service .NET CloudinaryDotNet pour uploader directement depuis le code C#.

Dites-moi ce que vous préférez !

