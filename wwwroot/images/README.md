# Images Folder

Place all your menu and product images in this folder.

## Image Requirements

- **Format**: JPG, PNG, or WebP
- **Recommended size**: 800x600px or larger
- **File naming**: Use lowercase with hyphens (e.g., `burger-classique.jpg`)

## Images Currently Available ✓

### Burgers (JPG/PNG)
- ✅ `burger-classique.jpg`
- ✅ `cheeseburger.jpg`
- ✅ `brochettes-poulet.png`
- ✅ `nuggets.png`
- ✅ `poulet-1.png`
- ✅ `poulet-2.png`
- ✅ `poulet-braise.png`
- ✅ `wings-bbq.png`
- ✅ `wings-epice.png`

### Wraps & Tacos (PNG)
- ✅ `wrap-poulet.png`
- ✅ `wrap-boeuf.png`
- ✅ `tacos-simple.png`
- ✅ `tacos-xl.png`

### Desserts (PNG)
- ✅ `glace.png`
- ✅ `donut.png`
- ✅ `crepe-sucree.png`
- ✅ `crepe-chocolat.png`
- ✅ `gateau.png`

### Complements - Boissons (PNG)
- ✅ `jus-bissap.png`
- ✅ `jus-gingembre.png`
- ✅ `jus-ananas.png`
- ✅ `milkshake-vanille.png`
- ✅ `milkshake-chocolat.png`
- ✅ `milkshake-fraise.png`

### Menus (PNG)
- ✅ `menu-etudiant.png`
- ✅ `menu-poulet.png`
- ✅ `menu-tacos.png`
- ✅ `menu-famille.png`

### Categories (PNG)
- ✅ `category-all.png`
- ✅ `category-menu.png`

## Images Manquantes ⚠️

Voir le fichier `IMAGES_MANQUANTES.md` pour la liste complète des images manquantes.

Les images manquantes seront automatiquement remplacées par un placeholder dans les vues.

## Accessing Images in Views

Images are served from the `/images/` path. For example:
```html
<img src="/images/burger-classique.jpg" alt="Burger Classique" />
```

## Notes

- Les vues gèrent automatiquement les images manquantes avec un placeholder
- Make sure image file names match exactly what's in the database
- You can use tools like [TinyPNG](https://tinypng.com/) to optimize images for web use
- Les extensions ont été corrigées dans Program.cs pour correspondre aux fichiers réels (.png au lieu de .jpg pour la plupart)
