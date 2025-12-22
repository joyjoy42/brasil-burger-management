# 🎯 Guide Complet - Changer Environnement Render de Docker vers .NET

## 🚨 Problème

Vous êtes dans Render Dashboard et :
- L'environnement est actuellement **"Docker"**
- Vous ne trouvez **pas l'option ".NET"** dans les paramètres

## ✅ Solution Étape par Étape

### Méthode 1 : Via Settings (Recommandé)

#### 1. Accéder aux Settings

1. **Render Dashboard** : https://dashboard.render.com
2. **Cliquez sur** votre service `brasil-burger-csharp`
3. **Menu de gauche** → **"Settings"** (ou onglet **"Settings"** en haut)

#### 2. Trouver la Section Environment

**Dans Settings, cherchez** :

**Option A : Section "Environment"**
- Généralement **en haut** de la page Settings
- Titre : **"Environment"** ou **"Runtime Environment"**

**Option B : Section "Build & Deploy"**
- Parfois l'environnement est dans cette section
- Cherchez **"Build Environment"** ou **"Runtime"**

**Option C : Section "Docker"**
- Si vous voyez une section "Docker"
- Cherchez une option **"Use Docker"** (case à cocher)
- **Décochez-la** pour activer .NET

#### 3. Changer l'Environnement

**Si vous voyez un dropdown "Environment" ou "Runtime"** :

1. **Cliquez sur** le dropdown
2. **Options possibles** :
   - `dotnet` ← **Sélectionnez celui-ci**
   - `.NET`
   - `Native`
   - `Docker` ← **Ne pas sélectionner**
   - `node`
   - `python`

**Si vous voyez "Dockerfile Path"** :

1. **Effacez** le contenu du champ "Dockerfile Path"
2. **Laissez-le vide**
3. Render utilisera alors .NET natif

**Si vous voyez une case "Use Docker"** :

1. **Décochez** la case "Use Docker"
2. Cela activera automatiquement .NET

#### 4. Sauvegarder

1. **Faites défiler** vers le bas
2. **Cliquez sur** **"Save Changes"** (bouton bleu)
3. Render va **redémarrer** le service automatiquement

---

### Méthode 2 : Via render.yaml (Automatique)

**Si Render détecte `render.yaml`** :

1. **Vérifiez** que `render.yaml` est à la racine de la branche `csharp`
2. Le fichier contient `env: dotnet`
3. Render devrait **automatiquement** utiliser .NET

**Si Render n'utilise pas `render.yaml`** :

1. **Settings** → **"Build & Deploy"**
2. **"Build Command"** : Copiez depuis `render.yaml` :
   ```
   dotnet restore BrasilBurger.Web.csproj && dotnet publish BrasilBurger.Web.csproj -c Release -o ./publish
   ```
3. **"Start Command"** : Copiez depuis `render.yaml` :
   ```
   dotnet ./publish/BrasilBurger.Web.dll
   ```
4. **Sauvegardez**

---

### Méthode 3 : Créer un Nouveau Service

**Si vous ne trouvez toujours pas l'option** :

1. **Dashboard** → **"New +"** → **"Web Service"**
2. **Connectez** votre repository GitHub
3. **Branche** : Sélectionnez `csharp`
4. **Lors de la configuration** :
   - **Environment** : Sélectionnez **"dotnet"** ou **".NET"**
   - **Build Command** : `dotnet restore BrasilBurger.Web.csproj && dotnet publish BrasilBurger.Web.csproj -c Release -o ./publish`
   - **Start Command** : `dotnet ./publish/BrasilBurger.Web.dll`
5. **Variables d'environnement** : Ajoutez depuis `render.yaml`

---

## 🔍 Où Chercher Exactement

### Dans Render Dashboard

```
Dashboard
└── brasil-burger-csharp (Service)
    ├── Overview
    ├── Logs
    ├── Events
    ├── Settings  ← CLIQUEZ ICI
    │   ├── General
    │   ├── Environment  ← CHERchez ICI
    │   │   └── Environment: [Dropdown]  ← CHANGEZ ICI
    │   ├── Build & Deploy
    │   └── ...
    └── ...
```

### Options Possibles dans le Dropdown

- ✅ **dotnet** (recommandé)
- ✅ **.NET**
- ✅ **Native**
- ❌ **Docker** (ne pas utiliser)
- ❌ **Dockerfile** (ne pas utiliser)

---

## 📝 Checklist

- [ ] Accédé à Settings
- [ ] Trouvé la section Environment
- [ ] Changé de "Docker" vers "dotnet" ou ".NET"
- [ ] Sauvegardé les modifications
- [ ] Service redémarré automatiquement
- [ ] Vérifié dans les logs que .NET est utilisé

---

## 🆘 Besoin d'Aide ?

**Si vous ne trouvez toujours pas** :

1. **Faites une capture d'écran** de la page Settings
2. **Partagez-moi** :
   - Les sections visibles dans Settings
   - Les options disponibles dans les dropdowns
   - Le type de service (Web Service, etc.)

Et je vous guiderai précisément !

---

**Date** : Décembre 2025

