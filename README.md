# Brasil Burger Management

Application web de gestion de commandes pour le restaurant Brasil Burger, développée avec ASP.NET Core MVC.

## 📋 Description

Brasil Burger Management est une plateforme complète permettant aux clients de :
- Parcourir le catalogue de produits (burgers, menus, compléments, boissons)
- Ajouter des articles au panier
- Passer des commandes
- Suivre l'état de leurs commandes
- Gérer leur compte utilisateur

## 🛠️ Technologies

- **Framework** : ASP.NET Core 6.0 MVC
- **Base de données** : PostgreSQL (Neon)
- **ORM** : Entity Framework Core 6.0
- **Authentification** : Cookie-based Authentication
- **Hébergement d'images** : Cloudinary
- **Déploiement** : Docker + Render.com
- **Langage** : C#

## 📦 Structure du Projet

```
brasil-burger-management/
├── Controllers/          # Contrôleurs MVC
├── Data/                # DbContext et configuration base de données
├── Models/              # Entités et ViewModels
│   ├── Entities/        # Modèles de données
│   └── ViewModels/     # Modèles pour les vues
├── Services/            # Services métier
├── Views/               # Vues Razor
├── Helpers/             # Classes utilitaires
├── wwwroot/             # Fichiers statiques (CSS, images)
├── Migrations/          # Migrations Entity Framework
├── scripts/             # Scripts de déploiement et maintenance
└── BrasilBurger_Java/   # Projet Java (en développement)
```

## 🚀 Installation et Configuration

### Prérequis

- .NET 6.0 SDK
- PostgreSQL (ou compte Neon)
- Compte Cloudinary (pour les images)
- Docker (optionnel, pour le déploiement)

### Configuration

1. **Cloner le repository**
   ```bash
   git clone <repository-url>
   cd brasil-burger-management
   ```

2. **Configurer la base de données**
   
   Créer un fichier `appsettings.json` à partir de `appsettings.Example.json` :
   ```json
   {
     "ConnectionStrings": {
       "DefaultConnection": "Host=YOUR_HOST;Database=YOUR_DB;Username=YOUR_USER;Password=YOUR_PASSWORD;SSL Mode=Require"
     },
     "Cloudinary": {
       "CloudName": "YOUR_CLOUD_NAME",
       "ApiKey": "YOUR_API_KEY",
       "ApiSecret": "YOUR_API_SECRET"
     }
   }
   ```

3. **Appliquer les migrations**
   ```bash
   dotnet ef database update
   ```

4. **Lancer l'application**
   ```bash
   dotnet run
   ```

L'application sera accessible sur `https://localhost:5001` ou `http://localhost:5000`.

## 🎯 Fonctionnalités

### Catalogue
- Affichage des burgers, menus, compléments et boissons
- Détails des produits avec images
- Filtrage et recherche

### Panier
- Ajout/suppression d'articles
- Modification des quantités
- Calcul automatique du total
- Gestion des compléments (frites, boissons)

### Commandes
- Création de commandes depuis le panier
- Confirmation de commande
- Suivi de l'état des commandes
- Historique des commandes

### Authentification
- Inscription de nouveaux clients
- Connexion/Déconnexion
- Gestion de session (30 jours)
- Mot de passe oublié (en développement)

## 🗄️ Base de Données

### Entités principales

- **Clients** : Informations des utilisateurs
- **Burger** : Produits burgers et autres plats
- **Menu** : Menus combinés
- **Complement** : Accompagnements et boissons
- **Commande** : Commandes des clients
- **LigneCommande** : Détails des articles commandés
- **Paiement** : Informations de paiement

## 🐳 Déploiement avec Docker

### Build de l'image
```bash
docker build -t brasil-burger .
```

### Exécution du conteneur
```bash
docker run -p 10000:10000 brasil-burger
```

## ☁️ Déploiement sur Render.com

Le projet est configuré pour être déployé sur Render.com via le fichier `render.yaml`.

1. Connecter le repository GitHub à Render
2. Render détectera automatiquement le `render.yaml`
3. Les variables d'environnement seront configurées automatiquement

## 📝 Scripts Utiles

- `scripts/apply-migrations.sh` : Applique les migrations en production
- `scripts/check-database-connection.sh` : Vérifie la connexion à la base de données
- `UpdateDatabaseWithCloudinaryUrls.ps1` : Met à jour les URLs Cloudinary dans la base

## 🔧 Développement

### Ajouter une migration
```bash
dotnet ef migrations add NomDeLaMigration
```

### Mettre à jour la base de données
```bash
dotnet ef database update
```

### Générer le script SQL
```bash
dotnet ef migrations script
```

## 📸 Gestion des Images

Les images sont hébergées sur Cloudinary. Pour ajouter/modifier des images :

1. Uploader l'image sur Cloudinary dans le dossier `brasil-burger`
2. Copier l'URL générée
3. Mettre à jour l'entité correspondante dans `Program.cs` (seed data) ou via l'interface d'administration

## 🔐 Sécurité

- Authentification par cookies sécurisés
- Sessions avec expiration automatique
- Protection CSRF intégrée
- Validation des données côté serveur
- Connexion PostgreSQL avec SSL

## 📄 Licence

Ce projet est propriétaire et confidentiel.

## 👥 Contribution

Pour contribuer au projet, veuillez créer une branche depuis `main` et soumettre une pull request.

## 📞 Support

Pour toute question ou problème, contactez l'équipe de développement.

---

**Version** : 1.0.0  
**Dernière mise à jour** : 2024

