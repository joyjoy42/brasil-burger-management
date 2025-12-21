# 🍔 Brasil Burger - Système de Gestion de Restaurant

Application web ASP.NET Core pour la gestion d'un restaurant de burgers avec système de commande en ligne.

## 🚀 Fonctionnalités

- ✅ **Catalogue de produits** : Burgers, menus, accompagnements, boissons, desserts
- ✅ **Système d'authentification** : Inscription et connexion clients
- ✅ **Panier d'achat** : Gestion des commandes
- ✅ **Suivi des commandes** : Historique et statut en temps réel
- ✅ **Images CDN** : Hébergement sur Cloudinary pour performance maximale
- ✅ **Design moderne** : Interface responsive avec Bootstrap
- ✅ **Prix en FCFA** : Devise locale

## 🛠️ Technologies

- **Backend** : ASP.NET Core 6.0 MVC
- **Base de données** : SQLite avec Entity Framework Core
- **Authentification** : ASP.NET Core Identity / Cookie Authentication
- **Frontend** : Razor Views, Bootstrap 4.3.1, Font Awesome
- **CDN Images** : Cloudinary
- **ORM** : Entity Framework Core 6.0

## 📋 Prérequis

- .NET SDK 6.0 ou supérieur
- Un compte Cloudinary (gratuit : https://cloudinary.com)
- Git

## 🔧 Installation

### 1. Cloner le repository

```bash
git clone https://github.com/VOTRE_USERNAME/brasil-burger-management.git
cd brasil-burger-management
```

### 2. Configurer Cloudinary

1. Créez un compte sur https://cloudinary.com
2. Copiez `appsettings.Example.json` vers `appsettings.json`
3. Remplissez vos credentials Cloudinary :

```json
{
  "Cloudinary": {
    "CloudName": "votre-cloud-name",
    "ApiKey": "votre-api-key",
    "ApiSecret": "votre-api-secret"
  }
}
```

### 3. Uploader les images sur Cloudinary

1. Connectez-vous à votre compte Cloudinary
2. Créez un dossier `brasil-burger` dans Media Library
3. Uploadez toutes les images du dossier `wwwroot/images/`

### 4. Restaurer les packages

```bash
dotnet restore
```

### 5. Lancer l'application

```bash
dotnet run --project BrasilBurger.Web.csproj
```

L'application sera accessible sur :
- HTTP : http://localhost:5000
- HTTPS : https://localhost:5001

## 📁 Structure du Projet

```
brasil-burger-management/
├── Controllers/          # Contrôleurs MVC
├── Models/              # Modèles et ViewModels
│   ├── Entities/        # Entités de base de données
│   └── ViewModels/      # ViewModels pour les vues
├── Views/               # Vues Razor
│   ├── Account/         # Authentification
│   ├── Catalogue/       # Catalogue produits
│   ├── Commande/        # Gestion commandes
│   ├── Home/            # Page d'accueil
│   ├── Shared/          # Layouts partagés
│   └── Suivi/           # Suivi commandes
├── Services/            # Services métier
├── Data/                # Contexte EF Core
├── Helpers/             # Classes utilitaires
├── wwwroot/             # Fichiers statiques
│   ├── css/             # Styles CSS
│   ├── js/              # Scripts JavaScript
│   └── images/          # Images (backup local)
└── Program.cs           # Point d'entrée
```

## 🎨 Schéma de Couleurs

- **Primaire** : Orange (#FF6B35, #FF4500)
- **Secondaire** : Bleu foncé (#1A1A2E, #16213E)
- **Texte** : Gris foncé (#2D3748)

## 📊 Base de Données

### Tables Principales

- **Clients** : Utilisateurs du système
- **Burgers** : Tous les produits (burgers, poulet, wraps, desserts)
- **Menus** : Menus combos
- **Complements** : Accompagnements et boissons
- **Commandes** : Commandes clients
- **LignesCommande** : Détails des commandes
- **Paiements** : Informations de paiement

## 🔐 Sécurité

⚠️ **Important** : Ne commitez JAMAIS vos credentials Cloudinary !

Le fichier `.gitignore` est configuré pour exclure :
- `appsettings.json` (contient vos credentials)
- `appsettings.LOCAL.json` (backup local)
- Base de données SQLite

## 🚀 Déploiement

### Variables d'Environnement

Pour la production, utilisez des variables d'environnement :

```bash
export CLOUDINARY_CLOUD_NAME="votre-cloud-name"
export CLOUDINARY_API_KEY="votre-api-key"
export CLOUDINARY_API_SECRET="votre-api-secret"
```

## 📝 Documentation

- [Guide Cloudinary](CLOUDINARY_GUIDE_COMPLET.md)
- [Quick Start Cloudinary](CLOUDINARY_QUICK_START.md)
- [Migration Cloudinary](MIGRATION_CLOUDINARY_COMPLETE.md)
- [Résumé Images](IMAGES_UPDATE_SUMMARY.md)

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à :
1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request

## 📄 License

Ce projet est sous licence MIT.

## 📞 Contact

Pour toute question ou suggestion, n'hésitez pas à ouvrir une issue.

---

**Développé avec ❤️ pour Brasil Burger**
