# 🚀 Solution Immédiate - Images Ne S'Affichent Pas

## ⚡ Solution Rapide (5 minutes)

Les images ne s'affichent pas car elles n'existent probablement pas encore sur Cloudinary. Voici la solution **immédiate** :

---

## ✅ Option 1 : Utiliser des Placeholders (Recommandé pour Test)

### Étape 1 : Exécuter le Script SQL

1. **Connectez-vous à votre base de données Neon** :
   - Allez sur : https://console.neon.tech
   - Ouvrez votre base de données `neondb`
   - Cliquez sur **"SQL Editor"**

2. **Copiez et exécutez** le contenu de `Scripts/fix-images-placeholder.sql` :

```sql
-- Mettre à jour les burgers avec des placeholders
UPDATE burgers 
SET image = 'https://via.placeholder.com/800x600/FF6B35/FFFFFF?text=' || REPLACE(REPLACE(nom, ' ', '+'), '''', '')
WHERE image LIKE '%cloudinary%' OR image IS NULL;

-- Mettre à jour les menus avec des placeholders
UPDATE menus 
SET image = 'https://via.placeholder.com/800x600/FF6B35/FFFFFF?text=' || REPLACE(REPLACE(nom, ' ', '+'), '''', '')
WHERE image LIKE '%cloudinary%' OR image IS NULL;

-- Mettre à jour les compléments avec des placeholders
UPDATE complements 
SET image = 'https://via.placeholder.com/400x300/FF6B35/FFFFFF?text=' || REPLACE(REPLACE(nom, ' ', '+'), '''', '')
WHERE image LIKE '%cloudinary%' OR image IS NULL;
```

3. **Rafraîchissez votre application** → Les images placeholder devraient maintenant s'afficher !

---

## ✅ Option 2 : Uploader les Images sur Cloudinary

### Étape 1 : Préparer les Images

Assurez-vous d'avoir toutes les images nécessaires :
- `burger-classique.jpg`
- `cheeseburger.jpg`
- `menu-etudiant.png`
- `menu-poulet.png`
- etc.

### Étape 2 : Uploader sur Cloudinary

1. **Allez sur** : https://console.cloudinary.com
2. **Connectez-vous** avec :
   - Cloud Name: `dbkji1d1j`
   - API Key: `166294258315442`
   - API Secret: `9bpSi55tkiP5IZnwNpHrMuw-Qsc`
3. **Media Library** → **Upload** → **Advanced**
4. **Folder** : `brasil-burger`
5. **Upload** toutes vos images
6. **Vérifiez** que les noms correspondent exactement à ceux dans la base de données

### Étape 3 : Vérifier les URLs

Testez une URL dans votre navigateur :
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique.jpg
```

Si l'image s'affiche → Les URLs dans la base de données sont correctes  
Si erreur 404 → L'image n'existe pas, vérifiez le nom

---

## 🔍 Diagnostic

### Vérifier les Images Actuelles dans la Base de Données

**Exécutez dans Neon SQL Editor** :

```sql
-- Voir les URLs des burgers
SELECT id, nom, image FROM burgers LIMIT 5;

-- Voir les URLs des menus
SELECT id, nom, image FROM menus LIMIT 5;
```

### Utiliser le Diagnostic Controller

Après redéploiement, accédez à :
```
https://votre-app.onrender.com/Diagnostic/CheckImages
```

Cela vous montrera quelles images sont accessibles.

---

## 📝 Checklist

- [ ] Exécuter le script SQL pour les placeholders (Option 1) OU
- [ ] Uploader toutes les images sur Cloudinary (Option 2)
- [ ] Vérifier qu'une URL Cloudinary fonctionne dans le navigateur
- [ ] Rafraîchir l'application
- [ ] Vérifier la console du navigateur (F12) pour les erreurs 404

---

## 💡 Note Importante

**Les placeholders sont temporaires**. Pour la production, vous devez :
1. Uploader toutes les vraies images sur Cloudinary
2. Exécuter `Scripts/fix-images-cloudinary.sql` pour restaurer les URLs Cloudinary

---

**Date** : Décembre 2025


