# 🧪 Guide de Test - Application Java Brasil Burger

## 📋 Prérequis

1. **Java 17+** installé
2. **Maven** (optionnel, pour compilation automatique)
3. **PostgreSQL Neon** configuré (ou base de données locale)

## 🔧 Option 1 : Test avec Maven (Recommandé)

### Installation de Maven

**Windows (avec Chocolatey) :**
```powershell
choco install maven
```

**Windows (Manuel) :**
1. Télécharger depuis https://maven.apache.org/download.cgi
2. Extraire dans `C:\Program Files\Apache\maven`
3. Ajouter au PATH : `C:\Program Files\Apache\maven\bin`

**Vérifier l'installation :**
```bash
mvn --version
```

### Compilation et Exécution

```bash
cd BrasilBurger_Java

# Compiler le projet
mvn clean compile

# Exécuter l'application
mvn exec:java -Dexec.mainClass="com.brasilburger.App"
```

## 🔧 Option 2 : Test avec un IDE

### IntelliJ IDEA

1. **Ouvrir le projet** : File → Open → Sélectionner le dossier `BrasilBurger_Java`
2. **Configurer Maven** : IntelliJ détecte automatiquement `pom.xml`
3. **Synchroniser** : Clic droit sur `pom.xml` → Maven → Reload Project
4. **Exécuter** : Clic droit sur `App.java` → Run 'App.main()'

### Eclipse

1. **Importer** : File → Import → Maven → Existing Maven Projects
2. **Sélectionner** : Le dossier `BrasilBurger_Java`
3. **Exécuter** : Clic droit sur `App.java` → Run As → Java Application

### VS Code

1. **Ouvrir le dossier** : File → Open Folder → `BrasilBurger_Java`
2. **Installer l'extension** : "Extension Pack for Java" (Microsoft)
3. **Exécuter** : Clic droit sur `App.java` → Run Java

## 🔧 Option 3 : Compilation Manuelle (Avancé)

Si vous n'avez pas Maven, vous pouvez compiler manuellement :

```bash
cd BrasilBurger_Java

# Créer le dossier de sortie
mkdir -p target/classes

# Télécharger les dépendances manuellement
# - Jackson : https://repo1.maven.org/maven2/com/fasterxml/jackson/core/jackson-databind/2.15.2/
# - PostgreSQL : https://repo1.maven.org/maven2/org/postgresql/postgresql/42.6.0/

# Compiler (ajuster les chemins selon votre installation)
javac -cp "target/dependency/*" -d target/classes src/main/java/com/brasilburger/**/*.java

# Exécuter
java -cp "target/classes;target/dependency/*" com.brasilburger.App
```

## ⚙️ Configuration de la Base de Données

### Avant de tester, configurez PostgreSQL

Éditez `src/main/resources/database.properties` :

```properties
db.host=votre-host-neon.neon.tech
db.port=5432
db.database=neondb
db.username=votre-username
db.password=votre-password
db.ssl=true
db.sslmode=require
```

### Ou utilisez les variables d'environnement

**Windows PowerShell :**
```powershell
$env:DB_HOST="votre-host-neon.neon.tech"
$env:DB_NAME="neondb"
$env:DB_USER="votre-username"
$env:DB_PASSWORD="votre-password"
```

**Windows CMD :**
```cmd
set DB_HOST=votre-host-neon.neon.tech
set DB_NAME=neondb
set DB_USER=votre-username
set DB_PASSWORD=votre-password
```

## 🧪 Test sans Base de Données (Mode Développement)

Si vous voulez tester sans base de données, vous pouvez créer une version de test qui utilise JSON en fallback.

## ✅ Vérification du Test

Lors du démarrage, vous devriez voir :

```
╔════════════════════════════════════════════════════════╗
║     BRASIL BURGER - GESTION DES RESSOURCES            ║
║     Application Console Java                          ║
║     Base de données: PostgreSQL (Neon)                ║
╚════════════════════════════════════════════════════════╝

🔌 Test de connexion à la base de données...
✅ Connexion à la base de données établie.
✅ Test de connexion réussi !

╔════════════════════════════════════════════════════════╗
║     BRASIL BURGER - GESTION DES RESSOURCES            ║
╚════════════════════════════════════════════════════════╝

1. Gestion des Burgers
2. Gestion des Menus
3. Gestion des Compléments
0. Quitter

Votre choix :
```

## 🐛 Résolution de Problèmes

### Erreur : "Maven not found"
→ Installez Maven ou utilisez un IDE

### Erreur : "Connection refused"
→ Vérifiez vos credentials dans `database.properties`
→ Vérifiez que la base de données Neon est accessible

### Erreur : "ClassNotFoundException"
→ Les dépendances ne sont pas téléchargées
→ Exécutez `mvn clean install` pour télécharger les dépendances

### Erreur : "Table does not exist"
→ Les tables n'existent pas encore dans la base de données
→ Créez les tables avec le script SQL dans `DATABASE_SETUP.md`

## 📝 Tests à Effectuer

1. **Test de connexion** : Vérifier que l'application se connecte à PostgreSQL
2. **Ajouter un burger** : Créer un nouveau burger
3. **Lister les burgers** : Voir tous les burgers
4. **Modifier un burger** : Modifier les informations
5. **Archiver un burger** : Soft delete
6. **Créer un menu** : Avec burgers et compléments
7. **Voir le prix du menu** : Calcul automatique

## 🎯 Commandes Rapides

```bash
# Compiler
mvn clean compile

# Exécuter
mvn exec:java -Dexec.mainClass="com.brasilburger.App"

# Package (créer un JAR)
mvn clean package

# Exécuter le JAR
java -jar target/BrasilBurger_Java-1.0-SNAPSHOT.jar
```

