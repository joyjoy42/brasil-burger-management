# 🐘 Brasil Burger - Application Symfony (Gestionnaire)

**Branche** : `symfony`  
**Livrable** : 30/12/2025 + Déploiement  
**Type** : Application web Symfony

---

## 🎯 Fonctionnalités Gestionnaire

Cette application Symfony permet au gestionnaire de gérer les commandes, les livraisons et les statistiques du restaurant.

### ✅ Authentification
- Connexion gestionnaire
- Sécurité des routes

### ✅ Gestion des Ressources
- **Burgers** : Ajouter, modifier, archiver (nom, prix, image)
- **Menus** : Ajouter, modifier, archiver (nom, image)
- **Compléments** : Ajouter, modifier, archiver (nom, prix, image)

### ✅ Gestion des Commandes
- Lister les commandes
- Annuler une commande (par nom, prénom, téléphone)
- Changer l'état de commande (Terminer)
- Filtrage des commandes :
  - Par burger ou menu
  - Par date
  - Par état
  - Par client

### ✅ Gestion des Livraisons
- Regrouper les commandes par zone
- Affecter un livreur à une livraison
- Gestion des zones (nom, prix)

### ✅ Statistiques
- **Commandes en cours de la journée**
- **Commandes validées de la journée**
- **Recettes journalières**
- **Burgers au menu les plus vendus de la journée**
- **Commandes annulées du jour**

---

## 📁 Structure du Projet

```
symfony/
├── README.md
├── config/
│   └── packages/
│       └── doctrine.yaml (configuration DB)
├── src/
│   ├── Controller/
│   │   ├── GestionnaireController.php
│   │   ├── CommandeController.php
│   │   └── StatistiqueController.php
│   ├── Entity/
│   │   ├── Burger.php
│   │   ├── Menu.php
│   │   ├── Complement.php
│   │   ├── Commande.php
│   │   └── ...
│   ├── Repository/
│   └── Service/
├── templates/
└── .env (configuration)
```

---

## 🔧 Prérequis

- **PHP 8.1+**
- **Composer**
- **Symfony CLI** (optionnel)
- **PostgreSQL Neon** configuré (base de données partagée)

---

## 🚀 Installation

### 1. Créer le Projet Symfony

```bash
# Si Symfony CLI installé
symfony new brasil-burger-symfony --version="6.3" --webapp

# Ou avec Composer
composer create-project symfony/skeleton brasil-burger-symfony
cd brasil-burger-symfony
composer require webapp
```

### 2. Installer les Dépendances

```bash
composer require doctrine/doctrine-bundle
composer require doctrine/orm
composer require symfony/orm-pack
composer require symfony/maker-bundle --dev
```

### 3. Configurer la Base de Données

Éditez `.env` :

```env
DATABASE_URL="postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech:5432/neondb?sslmode=require"
```

### 4. Créer les Entités

```bash
php bin/console make:entity
```

---

## 🗄️ Base de Données Partagée

Cette application partage la **même base de données PostgreSQL (Neon)** que :
- L'application Java Console (branche `java`)
- L'application C# ASP.NET MVC (branche `csharp`)

**⚠️ Important** : La base de données est créée **manuellement** (pas via migration Doctrine).  
Utilisez le script SQL de la branche `modelisation`.

---

## 🚀 Déploiement

**Plateforme** : Render.com (https://render.com/)

### Configuration Render

Créer un fichier `render.yaml` :

```yaml
services:
  - type: web
    name: brasil-burger-symfony
    env: php
    region: oregon
    plan: free
    buildCommand: composer install --no-dev --optimize-autoloader
    startCommand: symfony server:start --port=$PORT
    envVars:
      - key: APP_ENV
        value: prod
      - key: DATABASE_URL
        value: postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech:5432/neondb?sslmode=require
```

---

## 📝 Règles de Commit

**Un commit par fonctionnalité** :
- Exemple : `feat: Authentification gestionnaire`
- Exemple : `feat: Lister les commandes`
- Exemple : `feat: Statistiques journalières`

---

## 📚 Documentation

Pour plus d'informations sur le projet complet, consultez le `README.md` principal dans la branche `main`.

---

**Date** : Décembre 2025  
**Version** : 1.0  
**Statut** : À développer
