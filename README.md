# 📊 Brasil Burger - Modélisation

**Branche** : `modelisation`  
**Livrable** : 14/12/2025  
**Type** : Diagrammes UML, Maquettes, MLD, Script SQL

---

## 🎯 Contenu de cette Branche

Cette branche contient tous les éléments de modélisation et de conception du projet Brasil Burger :

### ✅ Diagrammes UML

- **Diagramme Use Case** : `Diagrammes/UseCase_Diagram.drawio.png`
  - Représentation des acteurs (Client, Gestionnaire) et des cas d'utilisation

- **Diagramme de Classe** : 
  - `Diagrammes/Class_Diagram.png`
  - `Diagrammes/Class_Diagram.drawio.png` (source Draw.io)
  - Structure des classes et leurs relations

- **Diagramme de Séquence** :
  - `Diagrammes/Sequence_Diagram_Commande.png` - Processus de commande
  - `Diagrammes/Sequence_Diagram_Livraison.drawio.png` - Processus de livraison

### ✅ Maquettes Figma

- **Dossier** : `Maquettes/`
- Maquettes de l'application mobile (client)
- Maquettes de l'application web gestionnaire
- Design system et composants UI

**Note** : Les maquettes Figma peuvent être partagées via un lien ou exportées dans ce dossier.

### ✅ MLD (Modèle Logique de Données)

- **Fichier** : `MLD/MLD_BrasilBurger.md`
- Modèle logique de la base de données
- Relations entre les tables
- Contraintes et règles métier
- Description détaillée de chaque table

### ✅ Script SQL

- **Fichier** : `Database/script_sql_creation.sql`
- Script de création de la base de données PostgreSQL
- Création des tables
- Contraintes, clés primaires et étrangères
- Index et optimisations
- Données de test (zones, livreurs)

---

## 📁 Structure de la Branche

```
modelisation/
├── README.md
├── Diagrammes/
│   ├── UseCase_Diagram.drawio.png
│   ├── Class_Diagram.png
│   ├── Class_Diagram.drawio.png
│   ├── Sequence_Diagram_Commande.png
│   └── Sequence_Diagram_Livraison.drawio.png
├── Maquettes/
│   └── (maquettes Figma à ajouter)
├── MLD/
│   └── MLD_BrasilBurger.md
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

### Tables de Jointure

- **MenuBurgers** : `menu_id`, `burger_id`
- **MenuComplements** : `menu_id`, `complement_id`

### ⚠️ Important

La base de données est créée **manuellement** (pas via migration).  
Le script SQL doit être exécuté directement sur PostgreSQL (Neon).

**Pour exécuter le script** :
```bash
psql 'postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech/neondb?sslmode=require' -f Database/script_sql_creation.sql
```

---

## 📝 Notes

- Les diagrammes peuvent être au format PNG, PDF, Draw.io, ou UML
- Les maquettes Figma peuvent être partagées via un lien dans `Maquettes/README.md`
- Le script SQL doit être testé avant d'être utilisé en production
- Tous les fichiers sont versionnés dans Git

---

## 🔗 Liens Utiles

- **Base de données** : PostgreSQL Neon (https://console.neon.tech)
- **Figma** : https://www.figma.com
- **Draw.io** : https://app.diagrams.net

---

## ✅ Checklist des Livrables

- [x] Diagramme Use Case
- [x] Diagramme de Classe
- [x] Diagramme de Séquence (commande)
- [x] Diagramme de Séquence (livraison)
- [x] MLD (Modèle Logique de Données)
- [x] Script SQL de création de la base de données
- [ ] Maquettes Figma (à ajouter)

---

**Date** : Décembre 2025  
**Version** : 1.0
