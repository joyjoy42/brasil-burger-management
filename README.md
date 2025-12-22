# ☕ Brasil Burger - Application Console Java

**Branche** : `java`  
**Livrable** : 14/12/2025 + Déploiement  
**Type** : Application console Java

---

## 🎯 Fonctionnalités

Cette application console permet au gestionnaire de créer et gérer les ressources du restaurant :

### ✅ Gestion des Burgers
- Ajouter un burger (nom, prix, image)
- Modifier un burger
- Archiver un burger (soft delete)

### ✅ Gestion des Menus
- Ajouter un menu (nom, image)
- Modifier un menu
- Archiver un menu
- Le prix d'un menu est calculé automatiquement (somme des prix des burgers et compléments)

### ✅ Gestion des Compléments
- Ajouter un complément (nom, prix, image)
- Modifier un complément
- Archiver un complément

---

## 📁 Structure du Projet

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
│   └── database.properties         # Configuration DB (template)
└── pom.xml                         # Configuration Maven
```

---

## 🔧 Prérequis

- **Java 17+**
- **Maven 3.6+** (optionnel, recommandé)
- **PostgreSQL Neon** configuré (base de données partagée)

---

## 🚀 Installation et Exécution

### Option 1 : Avec Maven

```bash
cd BrasilBurger_Java

# Compiler
mvn clean compile

# Exécuter
mvn exec:java
```

### Option 2 : Avec un IDE

**IntelliJ IDEA (Recommandé)** :
1. File → Open → Sélectionner `BrasilBurger_Java`
2. IntelliJ détecte automatiquement Maven
3. Clic droit sur `App.java` → Run 'App.main()'

**VS Code** :
1. Installer l'extension "Extension Pack for Java"
2. Ouvrir le dossier `BrasilBurger_Java`
3. Clic droit sur `App.java` → Run Java

### Option 3 : Script Windows

```bash
cd BrasilBurger_Java
run.bat
```

---

## ⚙️ Configuration

### 1. Configuration Base de Données

Éditez `src/main/resources/database.properties` :

```properties
db.host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech
db.port=5432
db.database=neondb
db.username=neondb_owner
db.password=npg_Q28lkcThzxRG
db.ssl=true
db.sslmode=require
```

**⚠️ Important** : Ne commitez jamais ce fichier avec les vrais identifiants !  
Utilisez `database.properties.example` comme template.

---

## 🗄️ Base de Données Partagée

Cette application partage la **même base de données PostgreSQL (Neon)** que :
- L'application C# ASP.NET MVC (branche `csharp`)
- L'application Symfony (branche `symfony`)

**Tables utilisées** :
- `Burgers`
- `Menus`
- `Complements`
- `MenuBurgers` (table de jointure)
- `MenuComplements` (table de jointure)

---

## 📝 Règles de Commit

**Un commit par fonctionnalité** :
- Exemple : `feat: Créer un menu`
- Exemple : `feat: Lister les menus`
- Exemple : `feat: Archiver un burger`

---

## 🚀 Déploiement

**Plateforme** : Render.com (optionnel pour application console)

Si déploiement nécessaire, créer un service Render avec :
- **Environment** : Java
- **Build Command** : `mvn clean package`
- **Start Command** : `java -jar target/BrasilBurger_Java-1.0-SNAPSHOT.jar`

---

## 📚 Documentation

Pour plus d'informations sur le projet complet, consultez le `README.md` principal dans la branche `main`.

---

**Date** : Décembre 2025  
**Version** : 1.0
