# 🚀 Release Notes - Brasil Burger Java Application

## Version 1.0.0

### ✨ Nouvelles Fonctionnalités

- ✅ **Interface Console Interactive** : Menu complet pour gérer les ressources
- ✅ **Connexion PostgreSQL Neon** : Intégration avec la base de données partagée
- ✅ **Gestion des Burgers** : CRUD complet (Ajouter, Modifier, Archiver, Rechercher)
- ✅ **Gestion des Menus** : CRUD complet avec calcul automatique du prix
- ✅ **Gestion des Compléments** : CRUD complet
- ✅ **Calcul Automatique** : Prix des menus = somme des burgers + compléments
- ✅ **Sauvegarde Automatique** : Persistance en temps réel dans PostgreSQL

### 🔧 Améliorations Techniques

- ✅ Architecture DAO pour l'accès aux données
- ✅ Gestion de connexion PostgreSQL avec pool
- ✅ Support SSL pour Neon PostgreSQL
- ✅ Variables d'environnement pour la configuration
- ✅ JAR exécutable avec toutes les dépendances (Maven Shade Plugin)

### 📚 Documentation

- ✅ README complet avec instructions
- ✅ Guide de test (TEST_GUIDE.md)
- ✅ Guide de déploiement (DEPLOYMENT.md)
- ✅ Guide de configuration base de données (DATABASE_SETUP.md)
- ✅ Guide de démarrage rapide (QUICK_START.md)

### 🐛 Corrections

- ✅ Ajout constructeur par défaut dans Menu.java
- ✅ Suppression ObjectMapper.java inutile
- ✅ Complétion DataLoader.java avec toutes les méthodes
- ✅ Amélioration BurgerService avec recherche et filtrage

### 📦 Dépendances

- Java 17+
- PostgreSQL JDBC Driver 42.6.0
- Jackson 2.15.2 (fallback JSON)

### 🚀 Utilisation

```bash
# Télécharger le JAR depuis la release
java -jar BrasilBurger_Java-1.0-SNAPSHOT.jar
```

### ⚙️ Configuration

Configurez les variables d'environnement ou éditez `database.properties` :

```properties
db.host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech
db.port=5432
db.database=neondb
db.username=neondb_owner
db.password=npg_Q28lkcThzxRG
```

### 📝 Notes

- Application console (pas d'interface web)
- Partage la même base de données que les projets C# et Symfony
- Les modifications sont synchronisées en temps réel

---

**Date de Release** : Décembre 2025  
**Auteur** : Projet L3 ISM - Semestre 1

