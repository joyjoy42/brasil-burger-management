# 🔧 Solution Erreur Build Render - "exit code: 1"

## ❌ Erreur

```
error: failed to solve: process "/bin/sh -c dotnet publish -c Release -o /app/publish" did not complete successfully: exit code: 1
```

## ✅ Solution

### Option 1 : Utiliser .NET Natif (Recommandé - Déjà Configuré)

**Render Dashboard** → Service → **Settings** → **Environment** :
- ✅ Sélectionnez **".NET"** (pas "Docker")
- ✅ Le `render.yaml` est déjà configuré avec `env: dotnet`

**Le `render.yaml` utilise maintenant** :
```yaml
buildCommand: dotnet restore BrasilBurger.Web.csproj && dotnet publish BrasilBurger.Web.csproj -c Release -o ./publish
startCommand: dotnet ./publish/BrasilBurger.Web.dll
```

### Option 2 : Si Render Utilise Docker

**Vérifiez dans Render Dashboard** :
1. Service → **Settings** → **Environment**
2. Si "Docker" est sélectionné, **changez pour ".NET"**

**Le Dockerfile a été corrigé** pour spécifier explicitement le `.csproj` :
```dockerfile
COPY BrasilBurger.Web.csproj ./
RUN dotnet restore BrasilBurger.Web.csproj
COPY . ./
RUN dotnet build BrasilBurger.Web.csproj -c Release --no-restore
RUN dotnet publish BrasilBurger.Web.csproj -c Release -o /app/publish --no-build
```

## 🔍 Diagnostic

### Vérifier les Logs Render

1. **Render Dashboard** → Service → **"Logs"**
2. **Cherchez** les erreurs spécifiques :
   - "Could not find project or directory"
   - "No project found"
   - Erreurs de compilation

### Test Local

**Testez le build en local** :
```bash
dotnet restore BrasilBurger.Web.csproj
dotnet build BrasilBurger.Web.csproj -c Release
dotnet publish BrasilBurger.Web.csproj -c Release -o ./publish
```

**Si erreur en local** :
- Vérifiez les erreurs de compilation
- Vérifiez que tous les fichiers sont présents
- Vérifiez les dépendances NuGet

## 📝 Checklist

- [ ] `BrasilBurger.Web.csproj` existe à la racine
- [ ] `render.yaml` spécifie le `.csproj` dans `buildCommand`
- [ ] Render utilise l'environnement **".NET"** (pas "Docker")
- [ ] `dotnet build` fonctionne en local
- [ ] `dotnet publish` fonctionne en local

## 🚀 Redéployer

1. **Render Dashboard** → Service → **"Manual Deploy"**
2. **"Deploy latest commit"**
3. **Attendez** la fin du build
4. **Vérifiez** les logs si erreur

---

**Date** : Décembre 2025

