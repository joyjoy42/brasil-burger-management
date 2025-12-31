# Brasil Burger Management

Projet L3 ISM – Gestion des commandes et livraisons (Brasil Burger)

## Description

Ce projet est une application web complète pour la gestion des commandes et livraisons du restaurant Brasil Burger. Il est développé en utilisant trois technologies différentes qui partagent la même base de données :

- **Symfony** (PHP) : Fonctionnalités de gestionnaire, commandes, suivi et statistiques
- **Java Console** : Création des ressources (burgers, menus, compléments)
- **C# ASP.NET MVC** : Fonctionnalités client

## Architecture

### Base de données partagée
- **SQLite** : Base de données unique partagée par les trois applications
- **Fichier** : `BrasilBurger.db`
- **Script SQL** : `database.sql`

### Structure du projet

```
brasil-burger-management/
├── BrasilBurger_Symfony/          # Application Symfony (gestionnaire)
├── BrasilBurger_Java/             # Application Java Console
├── BrasilBurger_CSharp/           # Application C# ASP.NET MVC
├── BrasilBurger.db                # Base de données SQLite
├── database.sql                   # Script de création de la BD
├── docker-compose.yml             # Configuration Docker
├── nginx.conf                     # Configuration Nginx
└── render.yaml                    # Configuration Render
```

## Fonctionnalités

### Gestionnaire (Symfony)
- ✅ CRUD des burgers, menus et compléments
- ✅ Gestion des commandes (liste, détails, suivi)
- ✅ Statistiques journalières
- ✅ Gestion des zones de livraison
- ✅ Authentification sécurisée

### Client (C# ASP.NET MVC)
- 📋 Consultation du catalogue
- 📋 Passation de commandes
- 📋 Suivi des commandes
- 📋 Paiement (Wave, OM)

### Ressources (Java Console)
- 📋 Création des burgers
- 📋 Création des menus
- 📋 Création des compléments

## Installation et Déploiement

### Prérequis
- Docker et Docker Compose
- PHP 8.2+
- Composer
- Node.js (pour les assets)

### Installation locale

1. **Cloner le projet**
```bash
git clone <repository-url>
cd brasil-burger-management
```

2. **Configurer la base de données**
```bash
# Créer la base de données avec le script SQL
sqlite3 BrasilBurger.db < database.sql
```

3. **Démarrer avec Docker**
```bash
docker-compose up -d
```

4. **Accéder aux applications**
- Symfony (Gestionnaire) : http://localhost:8080/login
- Identifiant : `admin@brasilburger.sn`
- Mot de passe : `admin123`

### Déploiement sur Render

1. **Connecter votre repository GitHub à Render**
2. **Utiliser le fichier `render.yaml` pour la configuration**
3. **Déployer la branche `symfony`**

## Statistiques disponibles

- 📊 Commandes en cours de la journée
- 📊 Commandes validées de la journée
- 📊 Recettes journalières
- 📊 Burgers au menu les plus vendus
- 📊 Commandes annulées du jour

## Technologies utilisées

### Symfony
- PHP 8.2
- Symfony 6.4
- Doctrine ORM
- Bootstrap 5
- Twig

### Docker
- PHP-FPM 8.2
- Nginx Alpine
- SQLite

### Sécurité
- Authentification par formulaire
- Hachage des mots de passe
- Protection CSRF
- Validation des entrées

## Branches Git

- `main` : Branche principale
- `modelisation` : Diagrammes et maquettes
- `java` : Application Java Console
- `csharp` : Application C# ASP.NET MVC
- `symfony` : Application Symfony

## Auteurs

- Équipe L3 ISM
- Projet Semestre 1

## Licence

Projet académique - Tous droits réservés
