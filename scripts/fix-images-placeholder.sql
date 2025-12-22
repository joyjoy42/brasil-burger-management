-- Script SQL pour remplacer les URLs Cloudinary par des placeholders temporaires
-- Ce script permet d'afficher des images placeholder en attendant d'uploader les vraies images sur Cloudinary

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

-- Vérifier les résultats
SELECT 'Burgers mis à jour :' as info, COUNT(*) as count FROM burgers WHERE image LIKE '%placeholder%'
UNION ALL
SELECT 'Menus mis à jour :', COUNT(*) FROM menus WHERE image LIKE '%placeholder%'
UNION ALL
SELECT 'Compléments mis à jour :', COUNT(*) FROM complements WHERE image LIKE '%placeholder%';

