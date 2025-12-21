# 🍔 Brasil Burger - Application Console Java

Application console Java pour la gestion des ressources (burgers, menus, compléments) du restaurant Brasil Burger.

## 📋 Fonctionnalités

### ✅ Gestion des Burgers
- ✅ Ajouter un burger (nom, prix, image)
- ✅ Modifier un burger
- ✅ Archiver/Désarchiver un burger
- ✅ Lister tous les burgers
- ✅ Lister uniquement les burgers actifs
- ✅ Rechercher un burger par nom

### ✅ Gestion des Menus
- ✅ Ajouter un menu (nom, image, composition de burgers et compléments)
- ✅ Modifier un menu
- ✅ Archiver/Désarchiver un menu
- ✅ Lister tous les menus
- ✅ Lister uniquement les menus actifs
- ✅ Voir les détails d'un menu (avec calcul automatique du prix total)
- ✅ **Calcul automatique du prix** : Le prix d'un menu = somme des prix des burgers + somme des prix des compléments

### ✅ Gestion des Compléments
- ✅ Ajouter un complément (nom, prix, image)
- ✅ Modifier un complément
- ✅ Archiver/Désarchiver un complément
- ✅ Lister tous les compléments
- ✅ Lister uniquement les compléments actifs
- ✅ Rechercher un complément par nom

### ✅ Persistance des Données
- ✅ Connexion automatique à PostgreSQL (Neon) au démarrage
- ✅ Sauvegarde automatique en temps réel dans la base de données
- ✅ Partage de données avec les projets C# et Symfony

## 🏗️ Architecture

```
BrasilBurger_Java/
├── src/main/java/com/brasilburger/
│   ├── App.java                    # Point d'entrée
│   ├── models/                     # Modèles de données
│   │   ├── Burger.java
│   │   ├── Menu.java
│   │   └── Complement.java
│   ├── services/                   # Logique métier
│   │   ├── BurgerService.java
│   │   ├── MenuService.java
│   │   └── ComplementService.java
│   ├── utils/                      # Utilitaires
│   │   └── DataLoader.java        # Chargement/Sauvegarde JSON
│   └── ui/                         # Interface utilisateur
│       └── MenuConsole.java       # Menu interactif console
├── resources/                      # Fichiers de données JSON
│   ├── burgers.json
│   ├── menus.json
│   └── complements.json
└── pom.xml                         # Configuration Maven
```

## 🚀 Compilation et Exécution

### Prérequis
- Java 17 ou supérieur
- Maven 3.6+

### Compilation
```bash
cd BrasilBurger_Java
mvn clean compile
```

### Exécution
```bash
mvn exec:java -Dexec.mainClass="com.brasilburger.App"
```

Ou après compilation :
```bash
java -cp target/classes:target/dependency/* com.brasilburger.App
```

## 📝 Structure de la Base de Données

Les données sont stockées dans PostgreSQL avec les tables suivantes :

- **Burgers** : id, nom, prix, image, archive
- **Menus** : id, nom, image, archive
- **Complements** : id, nom, prix, image, archive
- **MenuBurgers** : menu_id, burger_id (relation)
- **MenuComplements** : menu_id, complement_id (relation)

Voir [DATABASE_SETUP.md](DATABASE_SETUP.md) pour le script SQL complet.

## 🎯 Utilisation

1. **Configurer la base de données** : Éditez `database.properties` avec vos credentials Neon
2. **Lancer l'application** : Exécutez `App.java`
3. **Menu principal** : Choisissez entre :
   - Gestion des Burgers
   - Gestion des Menus
   - Gestion des Compléments
4. **Navigation** : Suivez les instructions à l'écran
5. **Sauvegarde** : Les données sont sauvegardées automatiquement en temps réel dans PostgreSQL

## 🔧 Améliorations Apportées

### ✅ Corrections
- ✅ Ajout du constructeur par défaut dans `Menu.java` (nécessaire pour Jackson)
- ✅ Suppression de la classe `ObjectMapper.java` inutile (conflit avec Jackson)

### ✅ Nouvelles Fonctionnalités
- ✅ `MenuService.java` : Service complet pour la gestion des menus
- ✅ `ComplementService.java` : Service complet pour la gestion des compléments
- ✅ `BurgerService.java` amélioré : Ajout de modifier, rechercher, filtrer
- ✅ `DataLoader.java` complet : Chargement et sauvegarde pour tous les types
- ✅ `MenuConsole.java` : Interface console interactive complète

### ✅ Fonctionnalités Avancées
- ✅ Calcul automatique du prix des menus
- ✅ Système d'archivage (soft delete)
- ✅ Recherche par nom
- ✅ Filtrage actifs/archivés
- ✅ Gestion des IDs automatique
- ✅ Validation des données

## 📊 Conformité au Cahier des Charges

✅ **Création de ressources** : Burgers, Menus, Compléments  
✅ **Modification** : Tous les types de ressources  
✅ **Archivage** : Soft delete pour tous les types  
✅ **Calcul du prix des menus** : Automatique (somme des composants)  
✅ **Persistance** : Fichiers JSON  
✅ **Interface console** : Menu interactif complet  

## 🐛 Problèmes Résolus

- ❌ Fichiers JSON vides → ✅ Chargement/Sauvegarde fonctionnels
- ❌ Services incomplets → ✅ Services complets avec CRUD
- ❌ Pas d'interface → ✅ Menu console interactif
- ❌ Pas de calcul de prix menu → ✅ Calcul automatique
- ❌ Pas de recherche → ✅ Recherche par nom
- ❌ Pas de filtrage → ✅ Filtrage actifs/archivés

## 📦 Dépendances

- **Jackson 2.15.2** : Sérialisation/Désérialisation JSON (fallback)
- **PostgreSQL JDBC 42.6.0** : Driver pour connexion PostgreSQL
- **Java 17** : Version minimale requise

## 🗄️ Base de Données

Le projet utilise **PostgreSQL (Neon)** partagée avec les projets C# et Symfony.

### Configuration

1. Éditez `src/main/resources/database.properties` avec vos credentials Neon
2. Ou utilisez les variables d'environnement : `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`

Voir [DATABASE_SETUP.md](DATABASE_SETUP.md) pour plus de détails.

### Avantages

- ✅ **Partage de données** : Les trois projets partagent la même base
- ✅ **Synchronisation** : Modifications visibles en temps réel
- ✅ **Persistance** : Données sauvegardées automatiquement
- ✅ **Cloud** : Base de données serverless Neon PostgreSQL

## 📝 Notes

- Les données sont stockées dans **PostgreSQL (Neon)** partagée avec C# et Symfony
- L'archivage est un soft delete (les données restent en base avec `archive = true`)
- Le prix des menus est calculé automatiquement à chaque affichage
- Les IDs sont générés automatiquement par la base de données (SERIAL)
- Les modifications sont persistées immédiatement (pas besoin de sauvegarder manuellement)

## 🎓 Auteur

Projet L3 ISM - Semestre 1  
Brasil Burger Management System

