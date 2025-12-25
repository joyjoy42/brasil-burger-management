# Organisation du Projet Brasil Burger Management

## 📁 Structure des Dossiers

### `/Controllers`
Contrôleurs MVC gérant les routes et la logique de présentation.

- **AccountController.cs** : Gestion de l'authentification (login, register, logout)
- **CatalogueController.cs** : Affichage du catalogue de produits
- **CommandeController.cs** : Gestion du panier et des commandes
- **SuiviController.cs** : Suivi des commandes clients
- **HomeController.cs** : Page d'accueil et erreurs
- **CloudinaryTestController.cs** : Tests et diagnostics Cloudinary
- **DiagnosticController.cs** : Outils de diagnostic système

### `/Data`
Configuration et contexte de base de données.

- **AppDbContext.cs** : DbContext Entity Framework avec configuration PostgreSQL

### `/Models`

#### `/Models/Entities`
Entités de domaine représentant les tables de la base de données.

- **Clients.cs** : Informations des clients/utilisateurs
- **Burger.cs** : Produits burgers et plats principaux
- **Menu.cs** : Menus combinés (combos)
- **Complement.cs** : Accompagnements (frites) et boissons
- **Commande.cs** : Commandes passées par les clients
- **LigneCommande.cs** : Détails des articles dans une commande
- **Paiement.cs** : Informations de paiement

#### `/Models/ViewModels`
Modèles de données pour les vues Razor.

- **CatalogueViewModel.cs** : Données pour la page catalogue
- **DetailsBurgerViewModel.cs** : Détails d'un burger
- **DetailsMenuViewModel.cs** : Détails d'un menu
- **PanierViewModel.cs** : Contenu du panier
- **ComplementPanierViewModel.cs** : Compléments dans le panier
- **CommandeViewModel.cs** : Données pour créer une commande
- **ConfirmationCommandeViewModel.cs** : Confirmation de commande
- **SuiviCommandeViewModel.cs** : Suivi d'une commande
- **LoginViewModel.cs** : Formulaire de connexion
- **RegisterViewModel.cs** : Formulaire d'inscription
- **ForgotPasswordViewModel.cs** : Récupération de mot de passe
- **ResetPasswordViewModel.cs** : Réinitialisation de mot de passe

### `/Services`
Services métier avec injection de dépendances.

- **ICatalogueService.cs** / **CatalogueService.cs** : Logique métier du catalogue
- **ICommandeService.cs** / **CommandeService.cs** : Gestion des commandes
- **IClientService.cs** / **ClientService.cs** : Gestion des clients
- **CloudinaryImageService.cs** : Service d'intégration Cloudinary
- **CloudinarySettings.cs** : Configuration Cloudinary

### `/Views`
Vues Razor organisées par contrôleur.

#### `/Views/Account`
- **Login.cshtml** : Page de connexion
- **Register.cshtml** : Page d'inscription
- **ForgotPassword.cshtml** : Mot de passe oublié
- **ResetPassword.cshtml** : Réinitialisation mot de passe
- **AccessDenied.cshtml** : Accès refusé

#### `/Views/Catalogue`
- **Index.cshtml** : Liste des produits
- **DetailsBurger.cshtml** : Détails d'un burger
- **DetailsMenu.cshtml** : Détails d'un menu

#### `/Views/Commande`
- **Panier.cshtml** : Panier d'achat
- **Confirmation.cshtml** : Confirmation de commande

#### `/Views/Suivi`
- **MesCommandes.cshtml** : Liste des commandes du client
- **Details.cshtml** : Détails d'une commande

#### `/Views/Home`
- **Index.cshtml** : Page d'accueil
- **Error.cshtml** : Page d'erreur

#### `/Views/Shared`
- **_Layout.cshtml** : Layout principal
- **_ValidationScriptsPartial.cshtml** : Scripts de validation

### `/Helpers`
Classes utilitaires et helpers.

- **CloudinaryHelper.cs** : Fonctions utilitaires Cloudinary
- **ImageHelper.cs** : Gestion des images

### `/wwwroot`
Fichiers statiques servis directement.

- **/css** : Feuilles de style
  - `site.css` : Styles globaux
  - `home.css` : Styles page d'accueil
  - `auth.css` : Styles authentification
- **/images** : Images locales (49 fichiers)

### `/Migrations`
Migrations Entity Framework pour la base de données.

- **InitialMigrationPostgreSQL.cs** : Migration initiale
- **AppDbContextModelSnapshot.cs** : Snapshot du modèle

### `/scripts`
Scripts de déploiement, maintenance et utilitaires.

- **apply-migrations.sh** : Applique les migrations en production
- **check-database-connection.sh** : Test de connexion DB
- **check-images.ps1** : Vérification des images
- **fix-images-cloudinary.sql** : Script SQL pour corriger les URLs Cloudinary
- **fix-images-placeholder.sql** : Script SQL pour placeholders
- **test-cloudinary-urls.ps1** : Tests des URLs Cloudinary
- **test-render-env.ps1** : Tests environnement Render
- **update-images-placeholder-direct.sql** : Mise à jour directe placeholders

### `/BrasilBurger_Java`
Projet Java (en développement).

- **/src/main/resources** : Configuration Java
  - `database.properties` : Configuration base de données PostgreSQL

## 🔄 Flux de Données

### Parcours Utilisateur Standard

1. **Accueil** → `HomeController.Index()`
2. **Catalogue** → `CatalogueController.Index()` → `CatalogueService.GetAllProducts()`
3. **Détails Produit** → `CatalogueController.Details()` → `CatalogueService.GetProductById()`
4. **Ajout au Panier** → `CommandeController.AddToCart()` → Session
5. **Voir Panier** → `CommandeController.Panier()` → `PanierViewModel`
6. **Passer Commande** → `CommandeController.CreateCommande()` → `CommandeService.CreateCommande()`
7. **Confirmation** → `CommandeController.Confirmation()`
8. **Suivi** → `SuiviController.MesCommandes()` → `CommandeService.GetClientCommandes()`

### Authentification

1. **Inscription** → `AccountController.Register()` → `ClientService.CreateClient()`
2. **Connexion** → `AccountController.Login()` → Cookie Authentication
3. **Session** : Cookie persistant 30 jours

## 🗄️ Schéma de Base de Données

### Tables Principales

```
Clients
├── Id (PK)
├── Nom
├── Email
├── Telephone
├── Adresse
└── MotDePasse (hashé)

Burger
├── Id (PK)
├── Nom
├── Description
├── Prix
└── Image (URL Cloudinary)

Menu
├── Id (PK)
├── Nom
├── Description
├── Prix
└── Image (URL Cloudinary)

Complement
├── Id (PK)
├── Nom
├── Type (frite/boisson)
├── Prix
└── Image (URL Cloudinary)

Commande
├── Id (PK)
├── ClientId (FK)
├── DateCommande
├── Statut
├── Total
└── AdresseLivraison

LigneCommande
├── Id (PK)
├── CommandeId (FK)
├── BurgerId (FK, nullable)
├── MenuId (FK, nullable)
├── ComplementId (FK, nullable)
├── Quantite
└── PrixUnitaire

Paiement
├── Id (PK)
├── CommandeId (FK)
├── Montant
├── Methode
└── Statut
```

## 🔧 Configuration

### Fichiers de Configuration

- **appsettings.json** : Configuration locale (non versionné)
- **appsettings.Example.json** : Template de configuration
- **database.properties** : Configuration Java (PostgreSQL)
- **render.yaml** : Configuration déploiement Render.com
- **Dockerfile** : Configuration Docker
- **brasil-burger-management.sln** : Solution Visual Studio

### Variables d'Environnement

- `ConnectionStrings__DefaultConnection` : Chaîne de connexion PostgreSQL
- `Cloudinary__CloudName` : Nom du cloud Cloudinary
- `Cloudinary__ApiKey` : Clé API Cloudinary
- `Cloudinary__ApiSecret` : Secret API Cloudinary
- `ASPNETCORE_ENVIRONMENT` : Environnement (Development/Production)
- `ASPNETCORE_URLS` : URLs d'écoute

## 📦 Dépendances Principales

### NuGet Packages

- `Microsoft.AspNetCore.Identity.EntityFrameworkCore` (6.0.0)
- `Microsoft.EntityFrameworkCore.Sqlite` (6.0.0)
- `Microsoft.EntityFrameworkCore.SqlServer` (6.0.0)
- `Npgsql.EntityFrameworkCore.PostgreSQL` (6.0.29)
- `Microsoft.EntityFrameworkCore.Tools` (6.0.0)
- `CloudinaryDotNet` (1.27.9)

## 🎨 Conventions de Code

### Nommage

- **Contrôleurs** : `[Nom]Controller.cs`
- **Services** : `I[Nom]Service.cs` (interface) et `[Nom]Service.cs` (implémentation)
- **Entités** : Nom au singulier (ex: `Burger`, `Commande`)
- **ViewModels** : `[Nom]ViewModel.cs`
- **Vues** : Nom de l'action (ex: `Index.cshtml`, `Details.cshtml`)

### Architecture

- **Pattern MVC** : Séparation claire Contrôleur/Modèle/Vue
- **Injection de Dépendances** : Services enregistrés dans `Program.cs`
- **Repository Pattern** : Via Entity Framework DbContext
- **Service Layer** : Logique métier dans les Services

## 🚀 Points d'Entrée

- **Program.cs** : Point d'entrée principal, configuration de l'application
- **Startup** : Configuration des services et middleware (dans Program.cs)
- **Route par défaut** : `{controller=Catalogue}/{action=Index}/{id?}`

## 📝 Notes Importantes

- Les images sont hébergées sur Cloudinary, pas localement
- La base de données est PostgreSQL (Neon) en production
- Les sessions utilisent des cookies persistants (30 jours)
- Le seed data est dans `Program.cs` (lignes 72-162)
- Le projet Java (`BrasilBurger_Java`) est en développement séparé

## 🔄 Workflow de Développement

1. Créer une branche depuis `main`
2. Développer la fonctionnalité
3. Ajouter les migrations si nécessaire : `dotnet ef migrations add [Nom]`
4. Tester localement
5. Créer une pull request
6. Après validation, merger dans `main`
7. Déploiement automatique sur Render.com (si configuré)

---

**Dernière mise à jour** : 2024

