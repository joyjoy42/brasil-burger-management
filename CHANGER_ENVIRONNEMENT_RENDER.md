# 🔧 Comment Changer l'Environnement de Docker vers .NET dans Render

## 📍 Étapes Détaillées

### Étape 1 : Accéder au Service

1. **Allez sur** : https://dashboard.render.com
2. **Connectez-vous** à votre compte
3. **Cliquez sur** votre service `brasil-burger-csharp`

### Étape 2 : Accéder aux Paramètres

**Option A : Via le Menu de Gauche**
1. Dans la page du service, regardez le **menu de gauche**
2. **Cliquez sur** **"Settings"** (Paramètres)

**Option B : Via l'En-tête**
1. En haut de la page du service, vous verrez des **onglets**
2. **Cliquez sur** **"Settings"** (à côté de "Logs", "Events", etc.)

### Étape 3 : Trouver la Section Environment

Dans la page **Settings**, vous verrez plusieurs sections :

1. **"Environment"** (Environnement) - **C'est ici !**
   - Cette section se trouve généralement **en haut** de la page Settings
   - Ou **dans la section "Build & Deploy"**

2. **Cherchez** :
   - Un champ/dropdown intitulé **"Environment"** ou **"Runtime"**
   - Ou **"Build Environment"**
   - Ou **"Docker"** avec une option pour changer

### Étape 4 : Changer l'Environnement

**Si vous voyez un dropdown "Environment" ou "Runtime"** :
1. **Cliquez sur** le dropdown
2. **Sélectionnez** **"dotnet"** ou **".NET"** ou **"Native"**
3. **PAS** "Docker" ou "Dockerfile"

**Si vous voyez une case à cocher "Use Docker"** :
1. **Décochez** la case "Use Docker"
2. Cela activera automatiquement l'environnement .NET

**Si vous voyez "Dockerfile Path"** :
1. **Effacez** ou **laissez vide** le champ "Dockerfile Path"
2. Render utilisera alors l'environnement .NET natif

### Étape 5 : Sauvegarder

1. **Faites défiler** vers le bas de la page Settings
2. **Cliquez sur** **"Save Changes"** (Sauvegarder les modifications)
3. Render va **redémarrer** automatiquement le service

---

## 🎯 Emplacement Exact dans Render

### Structure de la Page Settings

```
Settings
├── General
│   ├── Name
│   ├── Region
│   └── Plan
├── Environment          ← ICI !
│   ├── Environment (dropdown)  ← Changez ici
│   └── Environment Variables
├── Build & Deploy
│   ├── Build Command
│   ├── Start Command
│   └── Dockerfile Path  ← Si présent, laissez vide
└── ...
```

---

## 🔍 Si Vous Ne Trouvez Pas l'Option .NET

### Solution 1 : Vérifier le Type de Service

**Le service doit être de type "Web Service"** :
1. Settings → **"General"**
2. Vérifiez que **"Type"** est **"Web Service"**
3. Si c'est "Background Worker" ou autre, créez un nouveau service "Web Service"

### Solution 2 : Créer un Nouveau Service

Si vous ne trouvez toujours pas l'option :

1. **Créez un nouveau service** :
   - Dashboard → **"New +"** → **"Web Service"**
   - Connectez votre repository GitHub
   - **Sélectionnez** la branche `csharp`

2. **Lors de la création** :
   - **Environment** : Sélectionnez **"dotnet"** ou **".NET"**
   - **Build Command** : `dotnet restore BrasilBurger.Web.csproj && dotnet publish BrasilBurger.Web.csproj -c Release -o ./publish`
   - **Start Command** : `dotnet ./publish/BrasilBurger.Web.dll`

3. **Variables d'environnement** :
   - Ajoutez toutes les variables depuis `render.yaml`

### Solution 3 : Utiliser render.yaml

**Si Render détecte automatiquement `render.yaml`** :
1. Le fichier `render.yaml` spécifie `env: dotnet`
2. Render devrait **automatiquement** utiliser .NET
3. **Vérifiez** que `render.yaml` est bien à la racine de la branche `csharp`

---

## 📸 Aide Visuelle

### Ce Que Vous Devriez Voir

**Dans Settings → Environment** :

```
Environment
┌─────────────────────────────┐
│ [Dropdown]                  │
│ ▼                           │
│ • Docker                    │
│ • dotnet          ← Sélectionnez celui-ci
│ • node            │
│ • python          │
│ • ...             │
└─────────────────────────────┘
```

**OU**

```
☑ Use Docker  ← Décochez cette case
```

---

## ✅ Vérification

**Après avoir changé** :

1. **Settings** → **"Environment"**
2. **Vérifiez** que :
   - ✅ "Environment" = **"dotnet"** ou **".NET"**
   - ✅ "Dockerfile Path" est **vide** (si présent)
   - ✅ "Use Docker" est **décoché** (si présent)

3. **Redéployez** :
   - **"Manual Deploy"** → **"Deploy latest commit"**

---

## 🆘 Si Toujours Bloqué

**Partagez-moi** :
1. Une capture d'écran de la page Settings
2. Les options disponibles dans le dropdown "Environment"
3. Le type de service (Web Service, Background Worker, etc.)

Et je vous aiderai à trouver la solution exacte !

---

**Date** : Décembre 2025

