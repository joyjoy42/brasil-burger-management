# 🐘 Guide : Migration vers Neon PostgreSQL

## Qu'est-ce que Neon ?

**Neon** est une base de données PostgreSQL serverless moderne avec :
- ✅ Démarrage instantané
- ✅ Auto-scaling automatique
- ✅ Branches de base de données (comme Git)
- ✅ Plan gratuit généreux
- ✅ Haute disponibilité

---

## 📋 Étape 1 : Créer un compte Neon

1. Allez sur : https://neon.tech
2. Cliquez sur **Sign Up** (gratuit)
3. Connectez-vous avec GitHub, Google ou Email
4. Créez votre premier projet

### Configuration du Projet Neon

Lors de la création :
- **Project Name** : `brasil-burger`
- **Region** : Choisissez la plus proche (ex: `Europe (Frankfurt)` ou `US East`)
- **PostgreSQL Version** : 16 (ou la dernière)

---

## 📊 Étape 2 : Obtenir la Connection String

Une fois le projet créé :

1. Dans votre Dashboard Neon, cliquez sur votre projet
2. Allez dans **Connection Details**
3. Vous verrez une connection string comme :

```
postgresql://username:password@ep-xyz123.eu-central-1.aws.neon.tech/neondb?sslmode=require
```

### Format de la Connection String Neon

```
postgresql://[user]:[password]@[host]/[database]?sslmode=require
```

**Exemple :**
```
postgresql://neondb_owner:npg_abc123xyz@ep-cool-sound-12345678.eu-central-1.aws.neon.tech/neondb?sslmode=require
```

---

## ⚙️ Étape 3 : Configuration de l'Application

J'ai déjà installé le package `Npgsql.EntityFrameworkCore.PostgreSQL`.

### Prochaines Étapes

1. **Obtenez votre connection string Neon**
2. **Dites-moi votre connection string** (je la configurerai)
3. **Je mettrai à jour :**
   - `appsettings.json` avec la connection string
   - `Program.cs` pour utiliser PostgreSQL
   - Créer de nouvelles migrations PostgreSQL
   - Supprimer les anciennes migrations SQLite

---

## 🔒 Sécurité

⚠️ **Important** : La connection string contient votre mot de passe !

Pour la production, utilisez des variables d'environnement :
```bash
export DATABASE_URL="postgresql://..."
```

---

## 💡 Avantages de Neon vs SQLite

| Fonctionnalité | SQLite | Neon PostgreSQL |
|----------------|--------|-----------------|
| Multi-utilisateurs | ❌ Limité | ✅ Illimité |
| Performances | ✅ Rapide (local) | ✅ Très rapide (cloud) |
| Scalabilité | ❌ Limitée | ✅ Auto-scaling |
| Backup | ⚠️ Manuel | ✅ Automatique |
| Branches | ❌ Non | ✅ Oui (comme Git) |
| Concurrence | ❌ Limitée | ✅ Excellente |
| Déploiement | ⚠️ Fichier local | ✅ Cloud natif |

---

## 🎯 Ce qui va changer

### Avant (SQLite)
```csharp
builder.Services.AddDbContext<AppDbContext>(options =>
    options.UseSqlite(connectionString));
```

### Après (Neon PostgreSQL)
```csharp
builder.Services.AddDbContext<AppDbContext>(options =>
    options.UseNpgsql(connectionString));
```

---

## 📝 Prochaines Actions

Pour continuer, j'ai besoin que vous :

1. **Créez un compte Neon** (si pas déjà fait)
2. **Créez un projet** nommé `brasil-burger`
3. **Copiez la connection string** complète
4. **Partagez-la moi** (je la configurerai en sécurité)

Ensuite, je m'occuperai de :
- ✅ Configuration de l'application
- ✅ Migration des données
- ✅ Mise à jour du code
- ✅ Tests de connexion
- ✅ Documentation

---

## 🆓 Plan Gratuit Neon

Le plan gratuit inclut :
- 💾 **3 GB** de stockage
- ⚡ **Compute illimité** (avec auto-suspend)
- 🌿 **1 branche** (projet)
- 📊 **Monitoring basique**

**C'est largement suffisant pour démarrer !**

---

## 🔗 Ressources

- Documentation Neon : https://neon.tech/docs
- Dashboard Neon : https://console.neon.tech
- Support : https://neon.tech/discord

---

**Dites-moi quand vous avez votre connection string Neon, et je configurerai tout ! 🚀**

