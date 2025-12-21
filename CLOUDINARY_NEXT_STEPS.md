# Instructions pour appliquer les URLs Cloudinary

## Une fois que vous avez uploadé toutes les images sur Cloudinary :

1. Revenez ici et dites simplement : **"Upload terminé"**

2. Je vais automatiquement :
   - Supprimer l'ancienne base de données
   - Appliquer le nouveau Program.cs avec les URLs Cloudinary
   - Redémarrer l'application

## Ce qui sera changé

Tous les chemins `/images/...` seront remplacés par :
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/...
```

Par exemple :
```csharp
// AVANT
Image = "/images/burger-classique.jpg"

// APRÈS
Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique.jpg"
```

## Liste complète des remplacements (32 images)

| Image Locale | URL Cloudinary |
|--------------|----------------|
| /images/burger-classique.jpg | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique.jpg |
| /images/cheeseburger.jpg | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/cheeseburger.jpg |
| /images/wrap-poulet.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/wrap-poulet.png |
| /images/wrap-boeuf.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/wrap-boeuf.png |
| /images/nuggets.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/nuggets.png |
| /images/poulet-braise.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/poulet-braise.png |
| /images/jus-ananas.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/jus-ananas.png |
| /images/jus-bissap.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/jus-bissap.png |
| /images/jus-gingembre.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/jus-gingembre.png |
| /images/milkshake-vanille.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/milkshake-vanille.png |
| /images/milkshake-chocolat.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/milkshake-chocolat.png |
| /images/milkshake-fraise.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/milkshake-fraise.png |
| /images/poulet-1.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/poulet-1.png |
| /images/poulet-2.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/poulet-2.png |
| /images/wings-bbq.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/wings-bbq.png |
| /images/wings-epice.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/wings-epice.png |
| /images/brochettes-poulet.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/brochettes-poulet.png |
| /images/tacos-simple.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/tacos-simple.png |
| /images/tacos-xl.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/tacos-xl.png |
| /images/glace.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/glace.png |
| /images/donut.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/donut.png |
| /images/crepe-sucree.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/crepe-sucree.png |
| /images/crepe-chocolat.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/crepe-chocolat.png |
| /images/gateau.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/gateau.png |
| /images/menu-etudiant.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/menu-etudiant.png |
| /images/menu-poulet.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/menu-poulet.png |
| /images/menu-tacos.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/menu-tacos.png |
| /images/menu-famille.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/menu-famille.png |
| /images/logo.jpg | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/logo.jpg |
| /images/category-all.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/category-all.png |
| /images/category-burger.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/category-burger.png |
| /images/category-menu.png | https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/category-menu.png |

---

## À faire maintenant :

1. Uploadez vos images sur Cloudinary (voir UPLOAD_MANUEL_CLOUDINARY.md)
2. Revenez ici et dites : "Upload terminé"
3. Je m'occupe du reste !

