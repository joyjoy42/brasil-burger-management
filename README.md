<<<<<<< HEAD
# 🍔 Brasil Burger Management System

**Projet L3 ISM – Semestre 1**  
Gestion des commandes et livraisons pour le restaurant Brasil Burger

---

## 📋 Table des Matières

1. [Vue d'Ensemble](#vue-densemble)
2. [Architecture du Projet](#architecture-du-projet)
3. [Configuration des Services Cloud](#configuration-des-services-cloud)
4. [Projet Java (Console)](#projet-java-console)
5. [Projet C# (ASP.NET MVC)](#projet-c-aspnet-mvc)
6. [Projet Symfony](#projet-symfony)
7. [Base de Données Partagée](#base-de-données-partagée)
8. [Démarrage Rapide](#démarrage-rapide)
9. [Structure du Repository](#structure-du-repository)

---

## 🎯 Vue d'Ensemble

Le projet **Brasil Burger Management** est un système complet de gestion de commandes et livraisons pour un restaurant de burgers. Il est composé de **trois applications** qui partagent la **même base de données PostgreSQL (Neon)** :

- **Java Console** : Application console pour la création et gestion des ressources (burgers, menus, compléments)
- **C# ASP.NET MVC** : Application web pour les fonctionnalités client (catalogue, commandes, suivi)
- **Symfony** : Application web pour les fonctionnalités gestionnaire (commandes, statistiques, livraisons)

### 🏗️ Architecture Cloud

```
┌─────────────────────────────────┐
│         GitHub Repository        │
│   brasil-burger-management      │
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
     └────────┬────────┘
              │
              ▼
     ┌─────────────────┐
     │   Cloudinary    │
     │  (CDN Images)   │
     └─────────────────┘
```

---

## ⚙️ Configuration des Services Cloud

### 🔐 1. Neon PostgreSQL (Base de Données)

**Service** : Base de données PostgreSQL serverless  
**URL Console** : https://console.neon.tech  
**Région** : US East (par défaut)

#### 📝 Identifiants de Connexion

```properties
Host: ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech
Port: 5432
Database: neondb
Username: neondb_owner
Password: npg_Q28lkcThzxRG
SSL Mode: require
```

**Chaîne de connexion complète :**
```
postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech/neondb?sslmode=require&channel_binding=require
```

#### Configuration pour Java

Éditez `BrasilBurger_Java/src/main/resources/database.properties` :

```properties
db.host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech
db.port=5432
db.database=neondb
db.username=neondb_owner
db.password=npg_Q28lkcThzxRG
db.ssl=true
db.sslmode=require
```

#### Configuration pour C#

Éditez `appsettings.json` :

```json
{
  "ConnectionStrings": {
    "DefaultConnection": "Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"
  }
}
```

#### Variables d'Environnement (Alternative)

**Windows PowerShell :**
```powershell
$env:DB_HOST="ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech"
$env:DB_NAME="neondb"
$env:DB_USER="neondb_owner"
$env:DB_PASSWORD="npg_Q28lkcThzxRG"
```

**Linux/Mac :**
```bash
export DB_HOST="ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech"
export DB_NAME="neondb"
export DB_USER="neondb_owner"
export DB_PASSWORD="npg_Q28lkcThzxRG"
```

---

### 🖼️ 2. Cloudinary (CDN Images)

**Service** : CDN pour le stockage et la diffusion d'images  
**URL Dashboard** : https://console.cloudinary.com  
**Plan** : Gratuit (jusqu'à 25 GB)

#### 📝 Identifiants Cloudinary

```json
{
  "Cloudinary": {
    "CloudName": "dbkji1d1j",
    "ApiKey": "166294258315442",
    "ApiSecret": "9bpSi55tkiP5IZnwNpHrMuw-Qsc"
  }
}
```
#### Configuration pour C#

Éditez `appsettings.json` :

```json
{
  "Cloudinary": {
    "CloudName": "dbkji1d1j",
    "ApiKey": "166294258315442",
    "ApiSecret": "9bpSi55tkiP5IZnwNpHrMuw-Qsc"
  }
}
```

#### Où Trouver vos Identifiants

1. Connectez-vous à https://console.cloudinary.com
2. Allez dans **Settings** → **Security**
3. Copiez :
   - **Cloud Name** : Visible en haut du dashboard
   - **API Key** : Dans la section Security
   - **API Secret** : Cliquez sur "Reveal" pour l'afficher

---

## ☕ Projet Java (Console)

**Branche** : `java`  
**Type** : Application console Java  
**Rôle** : Création et gestion des ressources (burgers, menus, compléments)

### 📁 Structure

```
BrasilBurger_Java/
├── src/main/java/com/brasilburger/
│   ├── App.java                    # Point d'entrée
│   ├── models/                     # Modèles (Burger, Menu, Complement)
│   ├── services/                   # Services métier
│   ├── dao/                        # Data Access Objects (PostgreSQL)
│   ├── database/                   # Gestion connexion DB
│   └── ui/                         # Interface console
├── src/main/resources/
│   └── database.properties         # Configuration DB
└── pom.xml                         # Configuration Maven
```

### 🔧 Prérequis

- **Java 17+** (vous avez Java 24 ✅)
- **Maven 3.6+** (optionnel, recommandé)
- **PostgreSQL Neon** configuré

### 🚀 Installation et Exécution

#### Option 1 : Avec Maven

```bash
cd BrasilBurger_Java

# Compiler
mvn clean compile

# Exécuter
mvn exec:java
```

#### Option 2 : Avec un IDE

**IntelliJ IDEA (Recommandé) :**
1. File → Open → Sélectionner `BrasilBurger_Java`
2. IntelliJ détecte automatiquement Maven
3. Clic droit sur `App.java` → Run 'App.main()'

**VS Code :**
1. Installer l'extension "Extension Pack for Java"
2. Ouvrir le dossier `BrasilBurger_Java`
3. Clic droit sur `App.java` → Run Java

#### Option 3 : Script Windows

```bash
cd BrasilBurger_Java
run.bat
```

### ⚙️ Configuration

1. **Éditez** `src/main/resources/database.properties` avec vos identifiants Neon :

```properties
db.host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech
db.port=5432
db.database=neondb
db.username=neondb_owner
db.password=npg_Q28lkcThzxRG
db.ssl=true
db.sslmode=require
```

2. **Ou utilisez les variables d'environnement** (voir section Neon ci-dessus)

### ✅ Fonctionnalités

- ✅ Ajouter/Modifier/Archiver des burgers
- ✅ Ajouter/Modifier/Archiver des menus
- ✅ Ajouter/Modifier/Archiver des compléments
- ✅ Calcul automatique du prix des menus
- ✅ Recherche par nom
- ✅ Sauvegarde automatique dans PostgreSQL

### 📚 Documentation Java

- `BrasilBurger_Java/README.md` - Documentation complète
- `BrasilBurger_Java/DATABASE_SETUP.md` - Configuration base de données
- `BrasilBurger_Java/QUICK_START.md` - Démarrage rapide
- `BrasilBurger_Java/TEST_GUIDE.md` - Guide de test
- `BrasilBurger_Java/COMMENT_TESTER.md` - Comment tester

---

## 🖥️ Projet C# (ASP.NET MVC)

**Branche** : `csharp`  
**Type** : Application web ASP.NET Core MVC  
**Rôle** : Fonctionnalités client (catalogue, commandes, suivi)

### 📁 Structure

```
BrasilBurger.Web/
├── Controllers/          # Contrôleurs MVC
├── Models/              # Modèles de données
├── Views/               # Vues Razor
├── Services/            # Services métier
├── Migrations/          # Migrations Entity Framework
├── wwwroot/            # Fichiers statiques
├── appsettings.json    # Configuration
└── Program.cs          # Point d'entrée
```

### 🔧 Prérequis

- **.NET 6.0 SDK** ou supérieur
- **PostgreSQL Neon** configuré
- **Cloudinary** configuré

### 🚀 Installation et Exécution

```bash
# Restaurer les dépendances
dotnet restore

# Appliquer les migrations
dotnet ef database update

# Exécuter l'application
dotnet run
```

L'application sera accessible sur : `https://localhost:5001` ou `http://localhost:5000`

### ⚙️ Configuration

Éditez `appsettings.json` :

```json
{
  "ConnectionStrings": {
    "DefaultConnection": "Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"
  },
  "Cloudinary": {
    "CloudName": "dbkji1d1j",
    "ApiKey": "166294258315442",
    "ApiSecret": "9bpSi55tkiP5IZnwNpHrMuw-Qsc"
  }
}
```

### ✅ Fonctionnalités

- ✅ Authentification client (inscription/connexion)
- ✅ Catalogue de burgers et menus
- ✅ Filtrage par type (burger/menu)
- ✅ Détails des produits
- ✅ Panier d'achat
- ✅ Passer commande (sur place / à emporter / livraison)
- ✅ Suivi des commandes
- ✅ Paiement (Wave/OM)
- ✅ Gestion des compléments

---

## 🐘 Projet Symfony

**Branche** : `symfony`  
**Type** : Application web Symfony  
**Rôle** : Fonctionnalités gestionnaire (commandes, suivi, statistiques)

### 📋 Fonctionnalités Prévues

- ✅ Gestion des commandes
- ✅ Suivi des commandes
- ✅ Statistiques (commandes du jour, recettes, produits les plus vendus)
- ✅ Gestion des livraisons (zones, livreurs)
- ✅ Filtrage des commandes (par date, état, client, produit)

### ⚙️ Configuration

Configuration similaire à C# :
- Même base de données Neon PostgreSQL
- Même structure de tables
- Variables d'environnement pour les credentials

---

## 🗄️ Base de Données Partagée

Les **trois projets partagent la même base de données PostgreSQL (Neon)**.

### 📊 Structure des Tables

#### Tables Principales

- **Burgers** : `id`, `nom`, `prix`, `image`, `archive`
- **Menus** : `id`, `nom`, `image`, `archive`
- **Complements** : `id`, `nom`, `prix`, `image`, `archive`
- **Clients** : `id`, `nom`, `prenom`, `telephone`, `email`, `mot_de_passe`
- **Commandes** : `id`, `client_id`, `date`, `etat`, `type_livraison`, `zone_id`
- **LigneCommandes** : `id`, `commande_id`, `produit_type`, `produit_id`, `quantite`, `prix`
- **Paiements** : `id`, `commande_id`, `date`, `montant`, `methode` (Wave/OM)
- **Zones** : `id`, `nom`, `prix`
- **Livreurs** : `id`, `nom`, `prenom`, `telephone`

#### Tables de Jointure

- **MenuBurgers** : `menu_id`, `burger_id`
- **MenuComplements** : `menu_id`, `complement_id`

### 🔧 Script SQL de Création

Voir `BrasilBurger_Java/DATABASE_SETUP.md` pour le script SQL complet.

### ⚠️ Important

- **Synchronisation** : Les modifications d'un projet sont visibles dans les autres
- **Archivage** : Le soft delete (`archive = true`) est partagé
- **IDs** : Générés automatiquement par PostgreSQL (SERIAL)

---

## 🚀 Démarrage Rapide

### 1. Configuration Initiale

#### Étape 1 : Configurer Neon PostgreSQL

1. Créer un compte sur https://console.neon.tech
2. Créer un nouveau projet
3. Noter les identifiants de connexion
4. Configurer dans chaque projet (voir sections ci-dessus)

#### Étape 2 : Configurer Cloudinary

1. Créer un compte sur https://cloudinary.com
2. Noter les identifiants (Cloud Name, API Key, API Secret)
3. Configurer dans `appsettings.json` (C#)

#### Étape 3 : Créer les Tables

Exécutez le script SQL dans `BrasilBurger_Java/DATABASE_SETUP.md` ou utilisez les migrations Entity Framework (C#).

### 2. Tester le Projet Java

```bash
cd BrasilBurger_Java

# Configurer database.properties
# Puis :
mvn clean compile
mvn exec:java
```

### 3. Tester le Projet C#

```bash
# Configurer appsettings.json
# Puis :
dotnet restore
dotnet ef database update
dotnet run
```

---

## 📁 Structure du Repository

```
brasil-burger-management/
├── README.md                    # Ce fichier
├── appsettings.json             # Configuration C# (template)
│
├── BrasilBurger_Java/           # Projet Java Console
│   ├── src/
│   ├── pom.xml
│   ├── README.md
│   ├── DATABASE_SETUP.md
│   └── database.properties      # Configuration DB Java
│
├── BrasilBurger.Web/            # Projet C# ASP.NET MVC
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   ├── appsettings.json
│   └── Program.cs
│
└── [Symfony]/                   # Projet Symfony (à venir)
    └── ...
```

### 🌿 Branches Git

- **`main`** : Branche principale
- **`modelisation`** : Diagrammes UML, maquettes Figma, MLD
- **`java`** : Application console Java
- **`csharp`** : Application web C# ASP.NET MVC
- **`symfony`** : Application web Symfony

---

## 🔒 Sécurité

### ⚠️ Important : Protection des Identifiants

**NE JAMAIS COMMITTER** les fichiers avec les vrais identifiants :

- ❌ `appsettings.json` avec vrais credentials
- ❌ `database.properties` avec vrais credentials
- ✅ Utiliser `.gitignore` pour exclure ces fichiers
- ✅ Utiliser des variables d'environnement en production
- ✅ Utiliser des placeholders dans les fichiers commités

### 📝 Fichiers à Ignorer

Ajoutez dans `.gitignore` :

```
# Configuration avec credentials
appsettings.json
**/database.properties
*.db
bin/
obj/
target/
```

---

## 📚 Documentation Complète

### Projet Java

- `BrasilBurger_Java/README.md` - Documentation complète
- `BrasilBurger_Java/DATABASE_SETUP.md` - Configuration base de données
- `BrasilBurger_Java/QUICK_START.md` - Démarrage rapide
- `BrasilBurger_Java/TEST_GUIDE.md` - Guide de test
- `BrasilBurger_Java/COMMENT_TESTER.md` - Comment tester

### Projet C#

- Documentation dans le projet C# (à compléter)

### Services Cloud

- `PUSH_NEON_GITHUB_SUCCESS.md` - Migration Neon PostgreSQL
- Documentation Cloudinary (dans le projet C#)

---

## 🐛 Résolution de Problèmes

### Erreur de Connexion PostgreSQL

1. Vérifiez vos identifiants dans `database.properties` (Java) ou `appsettings.json` (C#)
2. Vérifiez que la base de données Neon est accessible
3. Vérifiez le SSL Mode (doit être `require`)

### Erreur Cloudinary

1. Vérifiez vos identifiants dans `appsettings.json`
2. Vérifiez que votre compte Cloudinary est actif
3. Vérifiez les limites de votre plan gratuit

### Erreur "Table does not exist"

1. Créez les tables avec le script SQL dans `DATABASE_SETUP.md`
2. Ou exécutez les migrations Entity Framework : `dotnet ef database update`

---

## 📞 Support

Pour toute question ou problème :

1. Consultez la documentation dans chaque projet
2. Vérifiez les fichiers de configuration
3. Consultez les guides de démarrage rapide

---

## 📝 Notes Importantes

- ✅ Les **trois projets partagent la même base de données**
- ✅ Les modifications sont **synchronisées en temps réel**
- ✅ L'**archivage** (soft delete) est partagé entre tous les projets
- ✅ Les **images** sont stockées sur Cloudinary CDN
- ✅ La base de données est **serverless** (Neon PostgreSQL)

---

## 🎯 Prochaines Étapes

1. ✅ Configurer Neon PostgreSQL
2. ✅ Configurer Cloudinary
3. ✅ Tester le projet Java
4. ✅ Tester le projet C#
5. ⏳ Développer le projet Symfony
6. ⏳ Déployer sur Render.com

---

**Date de mise à jour** : Décembre 2025  
**Version** : 1.0  
**Statut** : En développement

---

## 📄 Licence

Projet académique L3 ISM - Semestre 1
