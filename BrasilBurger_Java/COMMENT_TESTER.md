# 🧪 Comment Tester l'Application Java

## ✅ État Actuel

- ✅ **Java 24** installé et fonctionnel
- ✅ **Code compilé** (dossier `target` existe)
- ⚠️ **Maven** non installé (nécessaire pour télécharger PostgreSQL JDBC)
- ⚠️ **Driver PostgreSQL** manquant dans les dépendances

## 🎯 Solutions pour Tester

### Option 1 : Installer Maven (Recommandé)

**Avec Chocolatey (Windows) :**
```powershell
# Ouvrir PowerShell en Administrateur
choco install maven
```

**Manuellement :**
1. Télécharger : https://maven.apache.org/download.cgi
2. Extraire dans : `C:\Program Files\Apache\maven`
3. Ajouter au PATH : `C:\Program Files\Apache\maven\bin`
4. Redémarrer le terminal

**Puis compiler et exécuter :**
```bash
cd "C:\Users\hp zion\Documents\brasil-burger-management\BrasilBurger_Java"
mvn clean compile
mvn exec:java
```

### Option 2 : Utiliser un IDE (Plus Simple)

#### IntelliJ IDEA (Recommandé)

1. **Télécharger** : https://www.jetbrains.com/idea/download/
2. **Installer** : Version Community (gratuite)
3. **Ouvrir le projet** :
   - File → Open
   - Sélectionner le dossier `BrasilBurger_Java`
4. **Attendre** : IntelliJ détecte `pom.xml` et télécharge automatiquement les dépendances
5. **Exécuter** :
   - Clic droit sur `src/main/java/com/brasilburger/App.java`
   - Run 'App.main()'

#### VS Code

1. **Installer VS Code** : https://code.visualstudio.com/
2. **Installer l'extension** : "Extension Pack for Java" (Microsoft)
3. **Ouvrir le projet** :
   - File → Open Folder
   - Sélectionner `BrasilBurger_Java`
4. **Exécuter** :
   - Clic droit sur `App.java`
   - Run Java

### Option 3 : Télécharger PostgreSQL JDBC Manuellement

Si vous ne pouvez pas installer Maven, téléchargez manuellement :

1. **Télécharger** : https://repo1.maven.org/maven2/org/postgresql/postgresql/42.6.0/postgresql-42.6.0.jar
2. **Placer** dans : `BrasilBurger_Java/target/dependency/`
3. **Compiler manuellement** :
```bash
cd "C:\Users\hp zion\Documents\brasil-burger-management\BrasilBurger_Java"
javac -cp "target/dependency/*" -d target/classes src/main/java/com/brasilburger/**/*.java
```
4. **Exécuter** :
```bash
java -cp "target/classes;target/dependency/*" com.brasilburger.App
```

## ⚙️ Configuration Requise Avant Test

### 1. Configurer la Base de Données

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

**OU** utilisez les variables d'environnement :

```powershell
$env:DB_HOST="votre-host-neon.neon.tech"
$env:DB_NAME="neondb"
$env:DB_USER="votre-username"
$env:DB_PASSWORD="votre-password"
```

### 2. Vérifier que les Tables Existent

Si les tables n'existent pas, créez-les avec le script SQL dans `DATABASE_SETUP.md`

## ✅ Test Réussi

Si tout fonctionne, vous verrez :

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

## 🎯 Recommandation

**Pour tester rapidement : Utilisez IntelliJ IDEA Community Edition**

C'est la solution la plus simple :
- ✅ Téléchargement gratuit
- ✅ Détection automatique de Maven
- ✅ Téléchargement automatique des dépendances
- ✅ Exécution en un clic
- ✅ Debug intégré

## 📚 Documentation

- Guide complet : `TEST_GUIDE.md`
- Démarrage rapide : `QUICK_START.md`
- Configuration DB : `DATABASE_SETUP.md`
- README : `README.md`

