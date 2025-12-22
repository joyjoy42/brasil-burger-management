# 📊 Modèle Logique de Données (MLD) - Brasil Burger

## 🎯 Vue d'Ensemble

Le MLD décrit la structure logique de la base de données PostgreSQL partagée entre les trois applications (Java, C#, Symfony).

---

## 📋 Liste des Tables

### Tables Principales

1. **Clients** : Informations des clients
2. **Burgers** : Catalogue des burgers
3. **Menus** : Catalogue des menus
4. **Complements** : Catalogue des compléments (frites, boissons)
5. **Commandes** : Commandes des clients
6. **LigneCommandes** : Détails des lignes de commande
7. **Paiements** : Informations de paiement
8. **Zones** : Zones de livraison
9. **Livreurs** : Informations des livreurs

### Tables de Jointure

10. **MenuBurgers** : Relation Many-to-Many entre Menus et Burgers
11. **MenuComplements** : Relation Many-to-Many entre Menus et Complements

---

## 🔗 Relations entre les Tables

```
Clients (1) ────< (N) Commandes
                        │
                        ├───< (N) LigneCommandes
                        │
                        └───< (1) Paiements

Menus (1) ────< (N) MenuBurgers >─── (N) Burgers
Menus (1) ────< (N) MenuComplements >─── (N) Complements

Zones (1) ────< (N) Commandes
Livreurs (1) ────< (N) Commandes
```

---

## 📊 Détail des Tables

### Table: Clients

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| nom | VARCHAR(100) | NOT NULL | Nom du client |
| prenom | VARCHAR(100) | NOT NULL | Prénom du client |
| telephone | VARCHAR(20) | NOT NULL, UNIQUE | Téléphone (unique) |
| email | VARCHAR(255) | NOT NULL, UNIQUE | Email (unique) |
| mot_de_passe | VARCHAR(255) | NOT NULL | Mot de passe hashé |
| date_creation | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Date de création |

---

### Table: Burgers

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| nom | VARCHAR(255) | NOT NULL | Nom du burger |
| prix | DECIMAL(10,2) | NOT NULL, >= 0 | Prix en FCFA |
| image | VARCHAR(500) | | URL de l'image (Cloudinary) |
| archive | BOOLEAN | DEFAULT FALSE | Soft delete |
| date_creation | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Date de création |

---

### Table: Menus

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| nom | VARCHAR(255) | NOT NULL | Nom du menu |
| image | VARCHAR(500) | | URL de l'image (Cloudinary) |
| archive | BOOLEAN | DEFAULT FALSE | Soft delete |
| date_creation | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Date de création |

**Note** : Le prix d'un menu est calculé dynamiquement (somme des prix des burgers et compléments).

---

### Table: Complements

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| nom | VARCHAR(255) | NOT NULL | Nom du complément |
| prix | DECIMAL(10,2) | NOT NULL, >= 0 | Prix en FCFA |
| image | VARCHAR(500) | | URL de l'image (Cloudinary) |
| archive | BOOLEAN | DEFAULT FALSE | Soft delete |
| date_creation | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Date de création |

---

### Table: Commandes

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| client_id | INTEGER | NOT NULL, FK → Clients | Client qui commande |
| date | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Date de la commande |
| etat | VARCHAR(50) | DEFAULT 'En attente' | État: En attente, Validée, En préparation, Terminée, Annulée, En livraison, Livrée |
| type_livraison | VARCHAR(50) | NOT NULL | Sur place, À emporter, Livraison |
| zone_id | INTEGER | FK → Zones | Zone de livraison (si livraison) |
| livreur_id | INTEGER | FK → Livreurs | Livreur assigné (si livraison) |
| total | DECIMAL(10,2) | NOT NULL, >= 0 | Montant total de la commande |
| adresse_livraison | TEXT | | Adresse (si livraison) |
| notes | TEXT | | Notes du client |

---

### Table: LigneCommandes

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| commande_id | INTEGER | NOT NULL, FK → Commandes | Commande parente |
| produit_type | VARCHAR(50) | NOT NULL | 'Burger' ou 'Menu' |
| produit_id | INTEGER | NOT NULL | ID du burger ou menu |
| quantite | INTEGER | NOT NULL, > 0 | Quantité commandée |
| prix | DECIMAL(10,2) | NOT NULL, >= 0 | Prix unitaire au moment de la commande |
| complement_ids | INTEGER[] | DEFAULT ARRAY[] | IDs des compléments ajoutés |

---

### Table: Paiements

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| commande_id | INTEGER | NOT NULL, UNIQUE, FK → Commandes | Commande payée (1 paiement = 1 commande) |
| date | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Date du paiement |
| montant | DECIMAL(10,2) | NOT NULL, >= 0 | Montant payé |
| methode | VARCHAR(50) | NOT NULL | Wave, OM, Espèces, Carte |
| reference | VARCHAR(255) | | Référence du paiement |
| statut | VARCHAR(50) | DEFAULT 'Validé' | Validé, En attente, Échoué |

**Contrainte** : Une commande ne peut être payée qu'une seule fois (UNIQUE sur commande_id).

---

### Table: Zones

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| nom | VARCHAR(255) | NOT NULL, UNIQUE | Nom de la zone |
| prix | DECIMAL(10,2) | NOT NULL, >= 0 | Prix de livraison pour cette zone |
| description | TEXT | | Description de la zone |

---

### Table: Livreurs

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| id | SERIAL | PRIMARY KEY | Identifiant unique |
| nom | VARCHAR(100) | NOT NULL | Nom du livreur |
| prenom | VARCHAR(100) | NOT NULL | Prénom du livreur |
| telephone | VARCHAR(20) | NOT NULL, UNIQUE | Téléphone (unique) |
| disponible | BOOLEAN | DEFAULT TRUE | Statut de disponibilité |

---

### Table: MenuBurgers (Jointure)

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| menu_id | INTEGER | NOT NULL, FK → Menus | Menu |
| burger_id | INTEGER | NOT NULL, FK → Burgers | Burger dans le menu |
| PRIMARY KEY | (menu_id, burger_id) | | Clé primaire composite |

---

### Table: MenuComplements (Jointure)

| Colonne | Type | Contraintes | Description |
|---------|------|-------------|-------------|
| menu_id | INTEGER | NOT NULL, FK → Menus | Menu |
| complement_id | INTEGER | NOT NULL, FK → Complements | Complément dans le menu |
| PRIMARY KEY | (menu_id, complement_id) | | Clé primaire composite |

---

## 🔑 Contraintes et Règles Métier

### Règles de Gestion

1. **Prix d'un Menu** : Calculé dynamiquement = somme des prix des burgers + somme des prix des compléments
2. **Paiement Unique** : Une commande ne peut être payée qu'une seule fois
3. **Soft Delete** : Les burgers, menus et compléments sont archivés (archive = TRUE) au lieu d'être supprimés
4. **États de Commande** : En attente → Validée → En préparation → Terminée (ou Annulée)
5. **Livraison** : Si type_livraison = 'Livraison', alors zone_id et livreur_id sont requis

### Index

- Index sur `Commandes.client_id` pour les recherches par client
- Index sur `Commandes.date` pour les statistiques journalières
- Index sur `Commandes.etat` pour le filtrage par état
- Index sur les colonnes `archive` pour les filtres actifs/archivés

---

## 📝 Notes Importantes

- **Base de données partagée** : Les trois applications (Java, C#, Symfony) utilisent la même base
- **Création manuelle** : La base est créée via script SQL (pas de migration)
- **Images** : Stockées sur Cloudinary (URLs dans les colonnes `image`)
- **Devise** : Tous les prix sont en FCFA (Franc CFA)

---

**Date** : Décembre 2025  
**Version** : 1.0

