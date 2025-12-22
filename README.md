# 📊 Brasil Burger - Modélisation

**Branche** : `modelisation`  
**Livrable** : 14/12/2025  
**Type** : Diagrammes UML, Maquettes, MLD, Script SQL

---

## 🎯 Contenu de cette Branche

Cette branche contient tous les éléments de modélisation et de conception du projet Brasil Burger :

### ✅ Diagrammes UML

- **Diagramme Use Case** : Représentation des acteurs et des cas d'utilisation
- **Diagramme de Classe** : Structure des classes et leurs relations
- **Diagramme de Séquence** : Interactions entre les objets pour les scénarios principaux

### ✅ Maquettes Figma

- Maquettes de l'application mobile (client)
- Maquettes de l'application web gestionnaire
- Design system et composants UI

### ✅ MLD (Modèle Logique de Données)

- Modèle logique de la base de données
- Relations entre les tables
- Contraintes et règles métier

### ✅ Script SQL

- Script de création de la base de données PostgreSQL
- Création des tables
- Contraintes, clés primaires et étrangères
- Index et optimisations

---

## 📁 Structure Attendue

```
modelisation/
├── README.md
├── Diagrammes/
│   ├── UseCase_Diagram.png (ou .drawio, .uml)
│   ├── Class_Diagram.png
│   └── Sequence_Diagram.png
├── Maquettes/
│   └── (liens Figma ou fichiers)
├── MLD/
│   └── MLD_BrasilBurger.md (ou .png, .pdf)
└── Database/
    └── script_sql_creation.sql
```

---

## 🗄️ Base de Données

### Tables Principales

- **Burgers** : `id`, `nom`, `prix`, `image`, `archive`
- **Menus** : `id`, `nom`, `image`, `archive`
- **Complements** : `id`, `nom`, `prix`, `image`, `archive`
- **Clients** : `id`, `nom`, `prenom`, `telephone`, `email`, `mot_de_passe`
- **Commandes** : `id`, `client_id`, `date`, `etat`, `type_livraison`, `zone_id`
- **LigneCommandes** : `id`, `commande_id`, `produit_type`, `produit_id`, `quantite`, `prix`
- **Paiements** : `id`, `commande_id`, `date`, `montant`, `methode` (Wave/OM)
- **Zones** : `id`, `nom`, `prix`
- **Livreurs** : `id`, `nom`, `prenom`, `telephone`
- **MenuBurgers** : `menu_id`, `burger_id` (table de jointure)
- **MenuComplements** : `menu_id`, `complement_id` (table de jointure)

### ⚠️ Important

La base de données est créée **manuellement** (pas via migration).  
Le script SQL doit être exécuté directement sur PostgreSQL (Neon).

---

## 📝 Notes

- Les diagrammes peuvent être au format PNG, PDF, Draw.io, ou UML
- Les maquettes Figma peuvent être partagées via un lien
- Le script SQL doit être testé avant d'être utilisé en production

---

## 🔗 Liens Utiles

- **Base de données** : PostgreSQL Neon (https://console.neon.tech)
- **Figma** : https://www.figma.com
- **Draw.io** : https://app.diagrams.net

---

**Date** : Décembre 2025  
**Version** : 1.0
