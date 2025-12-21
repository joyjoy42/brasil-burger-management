# 🚀 Démarrage Rapide - Test de l'Application Java

## ✅ Vérifications Rapides

### 1. Java est installé ?
```bash
java -version
```
✅ Vous avez Java 24 installé - Parfait !

### 2. Maven est installé ?
```bash
mvn --version
```

## 🎯 Option 1 : Avec Maven (Recommandé)

### Installation Maven (si nécessaire)

**Windows avec Chocolatey :**
```powershell
choco install maven
```

**Ou télécharger manuellement :**
- Site : https://maven.apache.org/download.cgi
- Extraire dans `C:\Program Files\Apache\maven`
- Ajouter au PATH : `C:\Program Files\Apache\maven\bin`

### Compilation et Exécution

```bash
cd BrasilBurger_Java

# Compiler
mvn clean compile

# Exécuter
mvn exec:java
```

**Ou utiliser le script :**
```bash
run.bat
```

## 🎯 Option 2 : Avec un IDE (Plus Simple)

### IntelliJ IDEA (Recommandé)

1. **Ouvrir** : File → Open → Sélectionner `BrasilBurger_Java`
2. **Attendre** : IntelliJ détecte automatiquement Maven et télécharge les dépendances
3. **Exécuter** : Clic droit sur `App.java` → Run 'App.main()'

### VS Code

1. **Ouvrir** : File → Open Folder → `BrasilBurger_Java`
2. **Extension** : Installer "Extension Pack for Java" (Microsoft)
3. **Exécuter** : Clic droit sur `App.java` → Run Java

## ⚙️ Configuration Base de Données

**IMPORTANT** : Avant de tester, configurez PostgreSQL !

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

**Ou utilisez les variables d'environnement :**

```powershell
$env:DB_HOST="votre-host"
$env:DB_NAME="neondb"
$env:DB_USER="votre-username"
$env:DB_PASSWORD="votre-password"
```

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

## 🐛 Problèmes Courants

### "Maven not found"
→ Installez Maven ou utilisez un IDE

### "Connection refused" ou erreur de connexion
→ Vérifiez `database.properties` avec vos vraies credentials Neon

### "Table does not exist"
→ Créez les tables avec le script SQL dans `DATABASE_SETUP.md`

## 📚 Plus d'Informations

- Guide complet : `TEST_GUIDE.md`
- Configuration DB : `DATABASE_SETUP.md`
- Documentation : `README.md`

