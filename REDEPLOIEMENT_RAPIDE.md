# ⚡ Redéploiement Rapide - Render.com

## 🚀 Étapes Rapides (2 minutes)

### Option A : Depuis Render Dashboard (Le Plus Simple)

1. **Ouvrez** : https://dashboard.render.com
2. **Cliquez** sur votre service `brasil-burger-csharp`
3. **Cliquez** sur **"Manual Deploy"** (en haut à droite)
4. **Sélectionnez** **"Deploy latest commit"**
5. **Attendez** 2-5 minutes
6. **Vérifiez** que le statut est **"Live"** (vert)

✅ **C'est tout !** Votre application est redéployée.

---

### Option B : Depuis GitHub (Si Auto-Deploy est activé)

1. **Vérifiez** que vos modifications sont commitées :
   ```bash
   git status
   ```

2. **Poussez** sur GitHub :
   ```bash
   git push origin csharp
   ```

3. **Attendez** 2-5 minutes (Render déploie automatiquement)

✅ **C'est tout !** Render déploie automatiquement.

---

## 🔍 Vérifier le Déploiement

### Dans Render Dashboard

1. **Onglet "Events"** :
   - Vous verrez : "Deploying..." → "Live" ✅

2. **Onglet "Logs"** :
   - Cherchez : "Application started" ou "Now listening on..."

3. **Testez l'URL** :
   - Allez sur : `https://brasil-burger-csharp.onrender.com`
   - Vérifiez que l'application fonctionne

---

## ⚠️ Si le Déploiement Échoue

1. **Vérifiez les logs** (Onglet "Logs")
2. **Vérifiez les variables d'environnement** (Settings → Environment)
3. **Vérifiez que la branche est `csharp`** (Settings → Build & Deploy)

---

**Date** : Décembre 2025


