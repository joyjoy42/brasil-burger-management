# ⚡ Action Immédiate - Résoudre l'Erreur 500

## 🎯 Suivez ces 3 Étapes (10 minutes)

---

## 📍 Étape 1 : Vérifier les Logs Render (3 min)

### Actions :
1. **Allez sur** : https://dashboard.render.com
2. **Connectez-vous** à votre compte
3. **Cliquez sur** votre service `brasil-burger-csharp`
4. **Cliquez sur l'onglet** **"Logs"** (en haut)
5. **Cherchez les erreurs** en **rouge**
6. **Copiez le message d'erreur** complet

### Ce que vous cherchez :
- ❌ Messages en rouge
- ❌ Erreurs commençant par `System.`, `Npgsql.`, `Microsoft.`
- ❌ Messages contenant "error", "exception", "failed"

**📝 Notez le message d'erreur exact** pour l'étape suivante.

---

## 📍 Étape 2 : Appliquer les Migrations (2 min)

### Actions :
1. **Dans Render Dashboard**, toujours sur votre service
2. **Cliquez sur l'onglet** **"Shell"** (à côté de "Logs")
3. **Attendez** que le shell se charge
4. **Tapez** cette commande :
   ```bash
   dotnet ef database update
   ```
5. **Appuyez sur Entrée**
6. **Attendez** le résultat

### Résultat attendu :
```
Applying migration '20231201_InitialMigration'.
Done.
```

### Si erreur :
- **"No migrations found"** → Les migrations n'existent pas encore
- **"Connection failed"** → Problème de connexion DB (voir étape 3)
- **Autre erreur** → Notez le message exact

---

## 📍 Étape 3 : Vérifier les Variables d'Environnement (5 min)

### Actions :
1. **Dans Render Dashboard**, toujours sur votre service
2. **Cliquez sur l'onglet** **"Environment"** (dans le menu de gauche)
3. **Vérifiez** que ces variables existent :

### ✅ Variables REQUISES :

| Nom de la Variable | Valeur |
|-------------------|--------|
| `ASPNETCORE_ENVIRONMENT` | `Production` |
| `ASPNETCORE_URLS` | `http://0.0.0.0:10000` |
| `ConnectionStrings__DefaultConnection` | `Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true` |
| `Cloudinary__CloudName` | `dbkji1d1j` |
| `Cloudinary__ApiKey` | `166294258315442` |
| `Cloudinary__ApiSecret` | `9bpSi55tkiP5IZnwNpHrMuw-Qsc` |

### ⚠️ IMPORTANT :
- **Utilisez `__` (double underscore)** pour `ConnectionStrings__DefaultConnection` et `Cloudinary__*`
- **Pas de `:` (deux-points)**, seulement `__`
- **Pas d'espaces** avant/après le `=`

### Si une variable manque :
1. **Cliquez sur** **"Add Environment Variable"**
2. **Tapez le nom** exact (copiez-collez depuis le tableau)
3. **Tapez la valeur** exacte (copiez-collez depuis le tableau)
4. **Cliquez sur** **"Save Changes"**

---

## 🔄 Étape 4 : Redéployer (2 min)

### Actions :
1. **Dans Render Dashboard**, toujours sur votre service
2. **Cliquez sur** **"Manual Deploy"** (en haut à droite)
3. **Sélectionnez** **"Deploy latest commit"**
4. **Cliquez sur** **"Deploy"**
5. **Attendez** la fin du build (2-5 minutes)
6. **Testez** votre application : https://brasil-burger-csharp.onrender.com

---

## ✅ Vérification Finale

### Testez votre application :
1. **Allez sur** : https://brasil-burger-csharp.onrender.com
2. **Vérifiez** que la page se charge
3. **Si erreur 500** → Retournez à l'étape 1 et partagez le message d'erreur

---

## 📞 Besoin d'Aide ?

**Partagez-moi** :
1. ✅ Le message d'erreur des logs (Étape 1)
2. ✅ Le résultat de `dotnet ef database update` (Étape 2)
3. ✅ Les variables d'environnement configurées (Étape 3)

Et je vous aiderai à résoudre le problème spécifique !

---

## 🎯 Causes Probables (90% des cas)

1. **Migrations non appliquées** → Résolu à l'Étape 2
2. **Variables d'environnement manquantes** → Résolu à l'Étape 3
3. **Connexion DB échouée** → Vérifiez `ConnectionStrings__DefaultConnection`

---

**Date** : Décembre 2025

