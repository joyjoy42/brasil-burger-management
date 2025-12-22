# 🔧 Résolution Erreur Build Docker - "exit code: 1"

## ❌ Erreur Rencontrée

```
error: failed to solve: process "/bin/sh -c dotnet publish -c Release -o /app/publish" did not complete successfully: exit code: 1
```

## 🔍 Causes Possibles

1. **Fichier .csproj non trouvé** : Le Dockerfile ne spécifie pas explicitement le fichier projet
2. **Erreurs de compilation** : Erreurs dans le code C#
3. **Dépendances manquantes** : Packages NuGet non restaurés correctement
4. **Structure de projet incorrecte** : Fichiers manquants ou mal organisés

## ✅ Solution Appliquée

### Dockerfile Corrigé

Le Dockerfile a été modifié pour :
1. **Spécifier explicitement** le fichier `.csproj` dans toutes les commandes
2. **Séparer** les étapes de restore, build et publish
3. **Optimiser** le build avec `--no-restore` et `--no-build`

### Nouveau Dockerfile

```dockerfile
# Stage 2: Build
FROM mcr.microsoft.com/dotnet/sdk:6.0 AS build
WORKDIR /src

# Copier le fichier .csproj et restaurer les dépendances
COPY BrasilBurger.Web.csproj ./
RUN dotnet restore BrasilBurger.Web.csproj

# Copier le reste des fichiers
COPY . ./
RUN dotnet build BrasilBurger.Web.csproj -c Release --no-restore

# Publier l'application
RUN dotnet publish BrasilBurger.Web.csproj -c Release -o /app/publish --no-build
```

## 🔧 Alternatives si l'Erreur Persiste

### Option 1 : Utiliser render.yaml (Sans Docker)

**Render Dashboard** → Service → **Settings** → **Environment** :
- Sélectionnez **".NET"** (pas "Docker")
- Le `render.yaml` est déjà configuré pour cela

### Option 2 : Vérifier les Erreurs de Compilation

**En local** :
```bash
dotnet build BrasilBurger.Web.csproj -c Release
```

**Cherchez les erreurs** :
- Erreurs de compilation
- Packages manquants
- Références incorrectes

### Option 3 : Vérifier la Structure du Projet

**Fichiers requis** :
- ✅ `BrasilBurger.Web.csproj` (à la racine)
- ✅ `Program.cs`
- ✅ `Controllers/`
- ✅ `Models/`
- ✅ `Views/`
- ✅ `Services/`

### Option 4 : Logs Détaillés

**Dans Render Dashboard** → **Logs** :
- Cherchez les erreurs spécifiques
- Les messages d'erreur indiqueront la cause exacte

## 📝 Checklist de Vérification

- [ ] `BrasilBurger.Web.csproj` existe à la racine
- [ ] Tous les fichiers source sont présents
- [ ] `dotnet build` fonctionne en local
- [ ] `dotnet publish` fonctionne en local
- [ ] Dockerfile spécifie explicitement le `.csproj`
- [ ] Render utilise l'environnement ".NET" (pas "Docker")

## 🚀 Test Local du Dockerfile

**Pour tester le Dockerfile en local** :

```bash
# Build l'image
docker build -t brasil-burger-test .

# Si erreur, voir les logs détaillés
docker build -t brasil-burger-test . --progress=plain --no-cache
```

## 💡 Solution Recommandée

**Pour Render.com, il est recommandé d'utiliser `render.yaml` avec `env: dotnet`** plutôt que Docker :

1. **Render Dashboard** → Service → **Settings**
2. **Environment** : Sélectionnez **".NET"**
3. **Build Command** : `dotnet restore && dotnet publish -c Release -o ./publish`
4. **Start Command** : `dotnet ./publish/BrasilBurger.Web.dll`

Le `render.yaml` est déjà configuré pour cela !

---

**Date** : Décembre 2025

