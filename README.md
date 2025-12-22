# 🍔 Brasil Burger Management System

**Projet L3 ISM – Semestre 1**  
Gestion des commandes et livraisons pour le restaurant Brasil Burger

---

## 📋 Table des Matières

1. [Vue d'Ensemble](#vue-densemble)
2. [Structure du Repository](#structure-du-repository)
3. [Branches du Projet](#branches-du-projet)
4. [Base de Données Partagée](#base-de-données-partagée)
5. [Déploiement](#déploiement)
6. [Configuration](#configuration)

---

## 🎯 Vue d'Ensemble

Le projet **Brasil Burger Management** est un système complet de gestion de commandes et livraisons pour un restaurant de burgers. Il est composé de **trois applications** qui partagent la **même base de données PostgreSQL (Neon)** :

- **Java Console** : Application console pour la création et gestion des ressources (burgers, menus, compléments)
- **C# ASP.NET MVC** : Application web pour les fonctionnalités client (catalogue, commandes, suivi)
- **Symfony** : Application web pour les fonctionnalités gestionnaire (commandes, statistiques, livraisons)

### 🏗️ Architecture

```
┌─────────────────────────────────┐
│         GitHub Repository        │
│   brasil-burger-management      │
│                                  │
│   Branches:                      │
│   - modelisation                 │
│   - java                         │
│   - csharp                       │
│   - symfony                      │
└────────────┬────────────────────┘
             │
     ┌───────┴────────┐
     │                │
     ▼                ▼
┌─────────┐    ┌──────────────┐
│  Java   │    │  C# / Symfony│
│ Console │    │  Web Apps    │
└────┬────┘    └──────┬───────┘
     │                │
     └────────┬───────┘
              │
              ▼
     ┌─────────────────┐
     │ Neon PostgreSQL │
     │  (Base de données│
     │    partagée)     │
     └─────────────────┘
```

---

## 🌿 Structure du Repository

Le repository contient **4 branches principales** :

### 📊 Branche `modelisation`
**Livrable** : 14/12/2025

**Contenu** :
- Diagramme Use Case
- Diagramme de Classe
- Diagramme de Séquence (conception)
- Maquettes Figma
- MLD (Modèle Logique de Données)
- Script SQL de création de la base de données

**Accès** :
```bash
git checkout modelisation
```

---

### ☕ Branche `java`
**Livrable** : 14/12/2025 + Déploiement

**Contenu** :
- Application console Java
- Création des ressources :
  - Burgers (ajouter, modifier, archiver)
  - Menus (ajouter, modifier, archiver)
  - Compléments (ajouter, modifier, archiver)
- Connexion à la base de données PostgreSQL partagée

**Accès** :
```bash
git checkout java
```

---

### 🖥️ Branche `csharp`
**Livrable** : 20/12/2025 + Déploiement

**Contenu** :
- Application ASP.NET MVC
- Fonctionnalités Client :
  - Catalogue de burgers et menus
  - Détails burger/menu
  - Commande (burger/menu)
  - Sélection compléments
  - Type de livraison (sur place / à emporter / livraison)
  - Panier
  - Authentification (inscription/connexion)
  - Suivi des commandes
  - Paiement (Wave/OM)
  - Filtrage catalogue (menu/burger)

**Accès** :
```bash
git checkout csharp
```

---

### 🐘 Branche `symfony`
**Livrable** : 30/12/2025 + Déploiement

**Contenu** :
- Application Symfony
- Fonctionnalités Gestionnaire :
  - Authentification gestionnaire
  - Ajouter/Modifier/Archiver burgers
  - Ajouter/Modifier/Archiver menus
  - Ajouter/Modifier/Archiver compléments
  - Lister les commandes
  - Annuler une commande (par nom, prénom, téléphone)
  - Changer l'état de commande (Terminer)
  - Gestion livraisons (regrouper par zone, affecter livreur)
  - Filtrage commandes (burger/menu, date, état, client)
  - Statistiques :
    - Commandes en cours de la journée
    - Commandes validées de la journée
    - Recettes journalières
    - Burgers au menu les plus vendus de la journée
    - Commandes annulées du jour

**Accès** :
```bash
git checkout symfony
```

---

## 🗄️ Base de Données Partagée

Les **trois projets partagent la même base de données PostgreSQL (Neon)**.

### 📊 Structure des Tables

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

### 📝 Script SQL

Le script SQL de création de la base de données se trouve dans la branche `modelisation`.

**⚠️ Important** : La base de données est créée **manuellement** (pas via migration).

---

## 🚀 Déploiement

**Plateforme** : Render.com (https://render.com/)

### Déploiement depuis GitHub

Chaque branche peut être déployée indépendamment sur Render :

1. **Branche `java`** : Application console (déploiement optionnel)
2. **Branche `csharp`** : Service Web Render (ASP.NET MVC)
3. **Branche `symfony`** : Service Web Render (Symfony)

### Configuration Render

Chaque branche contient un fichier `render.yaml` pour la configuration du déploiement.

**Variables d'environnement requises** :
- Connexion PostgreSQL (Neon)
- Identifiants Cloudinary (pour C#)
- Autres configurations spécifiques

---

## ⚙️ Configuration

### Base de Données PostgreSQL (Neon)

**Identifiants** :
```
Host: ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech
Port: 5432
Database: neondb
Username: neondb_owner
Password: npg_Q28lkcThzxRG
SSL Mode: require
```

**Chaîne de connexion complète** :
```
postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech/neondb?sslmode=require
```

### Cloudinary (CDN Images)

**Identifiants** :
```
Cloud Name: dbkji1d1j
API Key: 166294258315442
API Secret: 9bpSi55tkiP5IZnwNpHrMuw-Qsc
```

---

## 📝 Règles de Commit

**Un commit par fonctionnalité** :
- Exemple : `feat: Créer un menu`
- Exemple : `feat: Lister les menus`
- Exemple : `feat: Authentification client`

**Push à la fin de chaque projet** :
- Après avoir terminé toutes les fonctionnalités d'un projet
- Avant le déploiement

---

## 📅 Dates de Livraison

- **Livrable 1** : 14/12/2025
  - Modélisation
  - Java Console
  - Déploiement

- **Livrable 2** : 20/12/2025
  - C# ASP.NET MVC
  - Déploiement

- **Livrable 3** : 30/12/2025
  - Symfony
  - Déploiement

---

## 🔒 Sécurité

**⚠️ Important** : Ne jamais committer les fichiers avec les vrais identifiants :
- ❌ `appsettings.json` avec vrais credentials
- ❌ `database.properties` avec vrais credentials
- ✅ Utiliser `.gitignore` pour exclure ces fichiers
- ✅ Utiliser des variables d'environnement en production

---

## 📞 Support

Pour toute question ou problème :
1. Consultez le README spécifique de chaque branche
2. Vérifiez les fichiers de configuration
3. Consultez les guides de démarrage rapide

---

**Date de mise à jour** : Décembre 2025  
**Version** : 1.0  
**Statut** : En développement

---

## 📄 Licence

Projet académique L3 ISM - Semestre 1
