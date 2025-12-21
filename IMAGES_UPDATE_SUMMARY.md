# Mise à Jour des Images - Brasil Burger

## Date: 21 Décembre 2025

### Corrections Effectuées

✅ **Logo renommé**
- `logo.jpeg` → `logo.jpg`
- Le logo est maintenant correctement reconnu par l'application

✅ **Base de données recréée**
- L'ancienne base de données a été supprimée
- Une nouvelle base de données a été créée avec les chemins d'images corrects

✅ **Chemins d'images corrigés dans Program.cs**
Tous les produits utilisent maintenant des images qui existent réellement dans le dossier `wwwroot/images/`

✅ **Image catégorie burger créée**
- `category-burger.png` a été créée à partir de `burger-classique.jpg`

---

## Correspondance Images - Produits

### Burgers
- **Burger Classique** → burger-classique.jpg ✓
- **Cheeseburger** → cheeseburger.jpg ✓
- **Burger Poulet Croustillant** → burger-classique.jpg (fallback)
- **Burger Épicé** → cheeseburger.jpg (fallback)
- **Sandwich Shawarma Poulet** → wrap-poulet.png ✓
- **Sandwich Shawarma Bœuf** → wrap-boeuf.png ✓
- **Hot-dog** → burger-classique.jpg (fallback)

### Poulet & Grillades
- **Poulet Frit (1 morceau)** → poulet-1.png ✓
- **Poulet Frit (2 morceaux)** → poulet-2.png ✓
- **Poulet Frit (4 morceaux)** → poulet-1.png (fallback)
- **Chicken Wings BBQ** → wings-bbq.png ✓
- **Chicken Wings Épicés** → wings-epice.png ✓
- **Nuggets de Poulet** → nuggets.png ✓
- **Brochettes de Poulet** → brochettes-poulet.png ✓
- **Poulet Braisé** → poulet-braise.png ✓

### Wraps & Tacos
- **Wrap Poulet** → wrap-poulet.png ✓
- **Wrap Bœuf** → wrap-boeuf.png ✓
- **Tacos Simple** → tacos-simple.png ✓
- **Tacos XL** → tacos-xl.png ✓

### Desserts
- **Glace** → glace.png ✓
- **Donut** → donut.png ✓
- **Crêpe Sucrée** → crepe-sucree.png ✓
- **Crêpe Chocolat** → crepe-chocolat.png ✓
- **Gâteau Simple** → gateau.png ✓

### Accompagnements
- **Frites Classiques** → nuggets.png (fallback)
- **Frites Épicées** → nuggets.png (fallback)
- **Alloco** → nuggets.png (fallback)
- **Potatoes** → nuggets.png (fallback)
- **Riz Sauté** → poulet-braise.png (fallback)
- **Salade Fraîche** → wrap-poulet.png (fallback)

### Boissons
- **Eau Minérale** → jus-ananas.png (fallback)
- **Coca-Cola** → jus-ananas.png (fallback)
- **Fanta** → jus-ananas.png (fallback)
- **Sprite** → jus-ananas.png (fallback)
- **Jus Bissap** → jus-bissap.png ✓
- **Jus Gingembre** → jus-gingembre.png ✓
- **Jus Ananas** → jus-ananas.png ✓
- **Milkshake Vanille** → milkshake-vanille.png ✓
- **Milkshake Chocolat** → milkshake-chocolat.png ✓
- **Milkshake Fraise** → milkshake-fraise.png ✓

### Menus
- **Menu Étudiant** → menu-etudiant.png ✓
- **Menu Poulet** → menu-poulet.png ✓
- **Menu Tacos** → menu-tacos.png ✓
- **Menu Duo** → menu-etudiant.png (fallback)
- **Menu Famille** → menu-famille.png ✓

### Catégories
- **Tous** → category-all.png ✓
- **Burgers** → category-burger.png ✓
- **Menus** → category-menu.png ✓

---

## État de l'Application

🟢 **Application en ligne**
- HTTP: http://localhost:5000
- HTTPS: https://localhost:5001

✅ Tous les prix sont affichés en **FCFA**
✅ Toutes les images existantes sont maintenant correctement liées
✅ Les images manquantes utilisent des fallbacks appropriés

---

## Images Manquantes (avec Fallbacks)

Les produits suivants n'ont pas d'images spécifiques et utilisent des fallbacks :
- Frites (utilise nuggets.png)
- Boissons gazeuses: Coca, Fanta, Sprite (utilise jus-ananas.png)
- Accompagnements basiques (utilisent des images similaires)

**Note:** Si vous souhaitez ajouter des images spécifiques pour ces produits, placez-les dans `wwwroot/images/` et mettez à jour les chemins dans `Program.cs`.

