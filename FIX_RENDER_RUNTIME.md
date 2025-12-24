# 🔧 Correction Erreur Runtime Render - "invalid runtime dotnet"

## ❌ Erreur

```
services[0].runtime
invalid runtime dotnet pour le render
```

## 🔍 Cause

Render.com **ne supporte pas nativement** le runtime `dotnet` dans `render.yaml`.  
Les runtimes natifs supportés sont : Node.js, Python, Ruby, Go, Rust, Elixir.

Pour déployer une application .NET, il faut utiliser **Docker**.

---

## ✅ Solution

### Option 1 : Utiliser Docker (Recommandé - Déjà Configuré)

Le fichier `render.yaml` a été corrigé pour utiliser Docker :

```yaml
services:
  - type: web
    name: brasil-burger-csharp
    env: docker                    # ← Changé de "dotnet" à "docker"
    region: oregon
    plan: free
    dockerfilePath: ./Dockerfile   # ← Spécifie le Dockerfile
```

**Le Dockerfile** est déjà présent et configuré pour .NET 6.0.

### Option 2 : Configuration Manuelle dans Render Dashboard

Si vous préférez configurer manuellement :

1. **Render Dashboard** → Service → **Settings**
2. **Environment** : Sélectionnez **"Docker"** (pas ".NET")
3. **Dockerfile Path** : `./Dockerfile`
4. **Build Command** : (laissé vide, Docker gère)
5. **Start Command** : (laissé vide, Docker gère)

---

## 📝 Fichiers Requis

### 1. Dockerfile

Le `Dockerfile` est déjà présent dans la branche `csharp` :

```dockerfile
FROM mcr.microsoft.com/dotnet/aspnet:6.0 AS base
WORKDIR /app
EXPOSE 10000
ENV ASPNETCORE_URLS=http://+:10000

FROM mcr.microsoft.com/dotnet/sdk:6.0 AS build
WORKDIR /src
COPY BrasilBurger.Web.csproj ./
RUN dotnet restore BrasilBurger.Web.csproj
COPY . ./
RUN dotnet build BrasilBurger.Web.csproj -c Release --no-restore
RUN dotnet publish BrasilBurger.Web.csproj -c Release -o /app/publish --no-build

FROM base AS final
WORKDIR /app
COPY --from=build /app/publish .
ENTRYPOINT ["dotnet", "BrasilBurger.Web.dll"]
```

### 2. render.yaml

Le `render.yaml` est maintenant configuré avec `env: docker`.

---

## 🔄 Redéployer

Après avoir corrigé le `render.yaml` :

1. **Render Dashboard** → Service → **"Manual Deploy"**
2. **"Deploy latest commit"**
3. Render utilisera maintenant Docker pour builder et déployer

---

## ✅ Vérification

Après le déploiement, vérifiez :

1. **Logs Render** : Le build Docker devrait démarrer
2. **Pas d'erreur** "invalid runtime dotnet"
3. **Application accessible** sur l'URL Render

---

## 📚 Documentation Render

- **Runtimes natifs** : https://render.com/docs/native-runtimes
- **Docker** : https://render.com/docs/docker
- **render.yaml** : https://render.com/docs/render-yaml-spec

---

**Date** : Décembre 2025


