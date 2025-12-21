# 🔧 Correction Erreur Dockerfile sur Render

## ❌ Erreur Rencontrée

```
error: failed to solve: failed to read dockerfile: open Dockerfile: no such file or directory
```

## ✅ Solution

### Option 1 : Utiliser render.yaml (Recommandé - Déjà Configuré)

Le fichier `render.yaml` est déjà configuré avec `env: dotnet`, ce qui signifie que Render n'a **pas besoin** de Dockerfile.

**Si Render continue à chercher un Dockerfile :**

1. **Dans Render Dashboard** :
   - Allez dans votre service
   - Settings → Environment
   - Assurez-vous que **"Docker"** n'est **pas** sélectionné
   - Sélectionnez **".NET"** comme environnement

2. **Ou supprimez la ligne `dockerfilePath`** dans `render.yaml` si elle existe

### Option 2 : Créer un Dockerfile (Si Nécessaire)

Un `Dockerfile` a été créé à la racine du projet. Si Render l'utilise :

**Le Dockerfile est maintenant configuré pour :**
- ✅ .NET 6.0
- ✅ Port 10000
- ✅ Build optimisé (multi-stage)
- ✅ Entrypoint correct : `BrasilBurger.Web.dll`

### Option 3 : Configuration Manuelle dans Render

Si le problème persiste :

1. **Render Dashboard** → Votre service → **Settings**
2. **Environment** : Sélectionnez **".NET"** (pas "Docker")
3. **Build Command** :
   ```bash
   dotnet restore && dotnet publish -c Release -o ./publish
   ```
4. **Start Command** :
   ```bash
   dotnet ./publish/BrasilBurger.Web.dll
   ```

---

## 🔍 Vérification

### Vérifier que Render Utilise .NET (Pas Docker)

1. **Render Dashboard** → Service → **Settings**
2. **Environment** doit être : **".NET"** ou **"dotnet"**
3. **Pas** "Docker" ou "Dockerfile"

### Si Dockerfile est Utilisé

Le Dockerfile créé devrait fonctionner, mais assurez-vous que :
- Le fichier `.csproj` est à la racine OU
- Le chemin dans le Dockerfile est correct

---

## 📝 Note Importante

**Pour .NET sur Render, le Dockerfile n'est PAS nécessaire** si vous utilisez `env: dotnet` dans `render.yaml`.

L'erreur peut apparaître si :
- Render détecte automatiquement Docker au lieu de .NET
- La configuration n'est pas correctement lue

**Solution** : Forcer l'environnement .NET dans Render Dashboard.

---

## ✅ Résultat Attendu

Une fois corrigé :
- ✅ Build réussi sans erreur Dockerfile
- ✅ Application démarre correctement
- ✅ Pas d'erreur "failed to read dockerfile"

---

**Date** : Décembre 2025

