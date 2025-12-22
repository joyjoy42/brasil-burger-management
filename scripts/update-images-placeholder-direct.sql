-- Script SQL pour mettre à jour directement les images avec des placeholders
-- Ce script génère des URLs placeholder avec le nom du produit

-- Mettre à jour les burgers avec des placeholders basés sur le nom
UPDATE burgers 
SET image = 'https://via.placeholder.com/300x200/FF6B35/FFFFFF?text=' || REPLACE(REPLACE(REPLACE(nom, ' ', '+'), '''', ''), 'é', 'e')
WHERE image IS NULL OR image LIKE '%cloudinary%' OR image NOT LIKE 'https://via.placeholder.com%';

-- Mettre à jour les menus avec des placeholders basés sur le nom
UPDATE menus 
SET image = 'https://via.placeholder.com/300x200/FF6B35/FFFFFF?text=' || REPLACE(REPLACE(REPLACE(nom, ' ', '+'), '''', ''), 'é', 'e')
WHERE image IS NULL OR image LIKE '%cloudinary%' OR image NOT LIKE 'https://via.placeholder.com%';

-- Mettre à jour les compléments avec des placeholders basés sur le nom
UPDATE complements 
SET image = 'https://via.placeholder.com/300x200/FF6B35/FFFFFF?text=' || REPLACE(REPLACE(REPLACE(nom, ' ', '+'), '''', ''), 'é', 'e')
WHERE image IS NULL OR image LIKE '%cloudinary%' OR image NOT LIKE 'https://via.placeholder.com%';

-- Vérifier les résultats
SELECT 'Burgers mis à jour :' as info, COUNT(*) as count FROM burgers WHERE image LIKE '%placeholder%'
UNION ALL
SELECT 'Menus mis à jour :', COUNT(*) FROM menus WHERE image LIKE '%placeholder%'
UNION ALL
SELECT 'Compléments mis à jour :', COUNT(*) FROM complements WHERE image LIKE '%placeholder%';

