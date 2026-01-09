# 🔥 Brasil Burger - Projet de Gestion de Commandes

Bienvenue sur le dépôt officiel du projet **Brasil Burger**, une solution complète de gestion de restaurant spécialisé dans les burgers. Ce projet a été réalisé en utilisant trois technologies majeures (Symfony, C# ASP.NET MVC, et Java) partageant une base de données PostgreSQL unique.

## 🚀 Architecture du Projet

Le projet est structuré en **4 branches principales**, chacune correspondant à un livrable spécifique du cahier des charges :

### 1. [Modélisation (UML & MLD)](https://github.com/joyjoy42/brasil-burger-management/tree/modelisation)
- **Contenu** : Diagrammes de Cas d'Utilisation, Diagramme de Classes, Diagramme de Séquence de Conception et Modèle Logique de Données (MLD).
- **Livrable** : Consultable dans le fichier `MODELISATION.md` sur la branche `modelisation`.

### 2. [C# ASP.NET MVC (Partie Client)](https://github.com/joyjoy42/brasil-burger-management/tree/csharp)
- **Objectif** : Interface mobile/web pour les clients.
- **Fonctionnalités** : Consultation du catalogue, commande de burgers/menus, choix des compléments, suivi des commandes, authentification et paiement (Wave/OM).

### 3. [Java Console (Gestion des Ressources)](https://github.com/joyjoy42/brasil-burger-management/tree/java)
- **Objectif** : Application console pour la gestion brute des entités.
- **Fonctionnalités** : Gestion des burgers, menus et compléments via JDBC.

### 4. [Symfony (Interface Gestionnaire & Statistiques)](https://github.com/joyjoy42/brasil-burger-management/tree/symfony)
- **Objectif** : Interface d'administration riche pour le gestionnaire.
- **Fonctionnalités** : Tableau de bord, statistiques en temps réel (recettes, top burgers), gestion des commandes, affectation des livreurs par zone, et intégration **Cloudinary** pour le stockage des images.

---

## 📊 Base de Données Partagée

Toutes les applications se connectent à une base de données **Neon PostgreSQL** unique, garantissant la cohérence des données entre les plateformes.

- **Schéma SQL** : Disponible dans le dossier `database/` de ce dépôt.
- **Synchronisation** : Toutes les branches utilisent les mêmes identifiants de connexion sécurisés via variables d'environnement.

---

## 🛠️ Technologies Utilisées

- **Backend** : PHP 8.4 (Symfony 8), Java, C# (.NET 8)
- **Frontend** : Twig, Razor (MVC), CSS Vanilla (Manager UI)
- **Base de données** : PostgreSQL (Neon Cloud)
- **Stockage images** : Cloudinary
- **Formattage** : Laravel Pint (Symfony), standard C#/Java

## 📅 Déploiement

Le projet est conçu pour être déployé sur **Render.com**. Les configurations de déploiement sont intégrées dans le code source de chaque branche.

---
*Projet réalisé dans le cadre du semestre 1 - L3 ISM.*
