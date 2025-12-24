-- Script SQL pour restaurer les URLs Cloudinary (après avoir uploadé les images)
-- Utilisez ce script APRÈS avoir uploadé toutes les images sur Cloudinary dans le dossier "brasil-burger"

-- Restaurer les URLs Cloudinary pour les burgers
UPDATE burgers 
SET image = 'https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/' || 
    CASE 
        WHEN LOWER(nom) LIKE '%classique%' THEN 'burger-classique.jpg'
        WHEN LOWER(nom) LIKE '%cheese%' THEN 'cheeseburger.jpg'
        WHEN LOWER(nom) LIKE '%poulet%' AND LOWER(nom) LIKE '%1%' THEN 'poulet-1.png'
        WHEN LOWER(nom) LIKE '%poulet%' AND LOWER(nom) LIKE '%2%' THEN 'poulet-2.png'
        WHEN LOWER(nom) LIKE '%wrap%' AND LOWER(nom) LIKE '%poulet%' THEN 'wrap-poulet.png'
        WHEN LOWER(nom) LIKE '%wrap%' AND LOWER(nom) LIKE '%bœuf%' THEN 'wrap-boeuf.png'
        WHEN LOWER(nom) LIKE '%tacos%' AND LOWER(nom) LIKE '%simple%' THEN 'tacos-simple.png'
        WHEN LOWER(nom) LIKE '%tacos%' AND LOWER(nom) LIKE '%xl%' THEN 'tacos-xl.png'
        WHEN LOWER(nom) LIKE '%wings%' AND LOWER(nom) LIKE '%bbq%' THEN 'wings-bbq.png'
        WHEN LOWER(nom) LIKE '%wings%' AND LOWER(nom) LIKE '%épicé%' THEN 'wings-epice.png'
        WHEN LOWER(nom) LIKE '%nugget%' THEN 'nuggets.png'
        WHEN LOWER(nom) LIKE '%brochette%' THEN 'brochettes-poulet.png'
        WHEN LOWER(nom) LIKE '%braisé%' THEN 'poulet-braise.png'
        WHEN LOWER(nom) LIKE '%glace%' THEN 'glace.png'
        WHEN LOWER(nom) LIKE '%donut%' THEN 'donut.png'
        WHEN LOWER(nom) LIKE '%crêpe%' AND LOWER(nom) LIKE '%sucrée%' THEN 'crepe-sucree.png'
        WHEN LOWER(nom) LIKE '%crêpe%' AND LOWER(nom) LIKE '%chocolat%' THEN 'crepe-chocolat.png'
        WHEN LOWER(nom) LIKE '%gâteau%' THEN 'gateau.png'
        ELSE 'burger-classique.jpg'
    END
WHERE image LIKE '%placeholder%';

-- Restaurer les URLs Cloudinary pour les menus
UPDATE menus 
SET image = 'https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/' || 
    CASE 
        WHEN LOWER(nom) LIKE '%étudiant%' THEN 'menu-etudiant.png'
        WHEN LOWER(nom) LIKE '%poulet%' THEN 'menu-poulet.png'
        WHEN LOWER(nom) LIKE '%tacos%' THEN 'menu-tacos.png'
        WHEN LOWER(nom) LIKE '%duo%' THEN 'menu-etudiant.png'
        WHEN LOWER(nom) LIKE '%famille%' THEN 'menu-famille.png'
        ELSE 'menu-etudiant.png'
    END
WHERE image LIKE '%placeholder%';

-- Restaurer les URLs Cloudinary pour les compléments
UPDATE complements 
SET image = 'https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/' || 
    CASE 
        WHEN LOWER(nom) LIKE '%frite%' THEN 'nuggets.png'
        WHEN LOWER(nom) LIKE '%alloco%' THEN 'nuggets.png'
        WHEN LOWER(nom) LIKE '%potato%' THEN 'nuggets.png'
        WHEN LOWER(nom) LIKE '%riz%' THEN 'poulet-braise.png'
        WHEN LOWER(nom) LIKE '%salade%' THEN 'wrap-poulet.png'
        WHEN LOWER(nom) LIKE '%eau%' OR LOWER(nom) LIKE '%coca%' OR LOWER(nom) LIKE '%fanta%' OR LOWER(nom) LIKE '%sprite%' THEN 'jus-ananas.png'
        WHEN LOWER(nom) LIKE '%bissap%' THEN 'jus-bissap.png'
        WHEN LOWER(nom) LIKE '%gingembre%' THEN 'jus-gingembre.png'
        WHEN LOWER(nom) LIKE '%ananas%' THEN 'jus-ananas.png'
        WHEN LOWER(nom) LIKE '%milkshake%' AND LOWER(nom) LIKE '%vanille%' THEN 'milkshake-vanille.png'
        WHEN LOWER(nom) LIKE '%milkshake%' AND LOWER(nom) LIKE '%chocolat%' THEN 'milkshake-chocolat.png'
        WHEN LOWER(nom) LIKE '%milkshake%' AND LOWER(nom) LIKE '%fraise%' THEN 'milkshake-fraise.png'
        ELSE 'nuggets.png'
    END
WHERE image LIKE '%placeholder%';


