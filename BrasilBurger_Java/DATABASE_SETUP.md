# 🗄️ Configuration Base de Données PostgreSQL

Le projet Java partage la même base de données PostgreSQL (Neon) que les projets C# et Symfony.

## 📋 Configuration

### 1. Fichier de Configuration

Éditez le fichier `src/main/resources/database.properties` :

```properties
db.host=votre-host-neon.neon.tech
db.port=5432
db.database=neondb
db.username=votre-username
db.password=votre-password
db.ssl=true
db.sslmode=require
```

### 2. Variables d'Environnement (Alternative)

Vous pouvez aussi utiliser des variables d'environnement :

```bash
export DB_HOST=votre-host-neon.neon.tech
export DB_NAME=neondb
export DB_USER=votre-username
export DB_PASSWORD=votre-password
```

## 🗃️ Structure de la Base de Données

Le projet utilise les tables suivantes (partagées avec C# et Symfony) :

### Tables Principales

- **Burgers** : `id`, `nom`, `prix`, `image`, `archive`
- **Menus** : `id`, `nom`, `image`, `archive`
- **Complements** : `id`, `nom`, `prix`, `image`, `archive`

### Tables de Jointure

- **MenuBurgers** : `menu_id`, `burger_id` (relation many-to-many)
- **MenuComplements** : `menu_id`, `complement_id` (relation many-to-many)

## 🔌 Connexion

La classe `DatabaseConnection` gère automatiquement :
- ✅ Chargement de la configuration depuis `database.properties`
- ✅ Fallback sur les variables d'environnement
- ✅ Gestion du pool de connexions
- ✅ Support SSL pour Neon PostgreSQL

## 🚀 Utilisation

L'application se connecte automatiquement à la base de données au démarrage :

```java
DatabaseConnection dbConnection = DatabaseConnection.getInstance();
dbConnection.testConnection(); // Test de connexion
```

## ⚠️ Notes Importantes

1. **Même Base de Données** : Les trois projets (Java, C#, Symfony) partagent la même base PostgreSQL
2. **Synchronisation** : Les modifications faites dans un projet sont visibles dans les autres
3. **Archivage** : Le soft delete (`archive = true`) est partagé entre tous les projets
4. **IDs** : Les IDs sont gérés automatiquement par la base de données

## 🔒 Sécurité

- Les credentials ne doivent **jamais** être commités dans Git
- Utilisez `.gitignore` pour exclure `database.properties` avec les vraies valeurs
- Utilisez des variables d'environnement en production

## 📝 Exemple de Script SQL

Si vous devez créer les tables manuellement :

```sql
CREATE TABLE Burgers (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    archive BOOLEAN DEFAULT FALSE
);

CREATE TABLE Complements (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    archive BOOLEAN DEFAULT FALSE
);

CREATE TABLE Menus (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    archive BOOLEAN DEFAULT FALSE
);

CREATE TABLE MenuBurgers (
    menu_id INTEGER REFERENCES Menus(id),
    burger_id INTEGER REFERENCES Burgers(id),
    PRIMARY KEY (menu_id, burger_id)
);

CREATE TABLE MenuComplements (
    menu_id INTEGER REFERENCES Menus(id),
    complement_id INTEGER REFERENCES Complements(id),
    PRIMARY KEY (menu_id, complement_id)
);
```

## ✅ Test de Connexion

L'application teste automatiquement la connexion au démarrage. Si vous voyez :

```
✅ Connexion à la base de données établie.
✅ Test de connexion réussi !
```

Cela signifie que la connexion fonctionne correctement.

