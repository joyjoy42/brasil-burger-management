# 🚀 Guide de Redéploiement sur Render.com

## 📋 Méthodes de Redéploiement

Il existe plusieurs façons de redéployer votre application sur Render :

---

## ✅ Méthode 1 : Redéploiement Automatique (Recommandé)

### Si vous avez déjà poussé sur GitHub

1. **Vérifiez que vos modifications sont sur GitHub** :
   - Allez sur : https://github.com/joyjoy42/brasil-burger-management
   - Vérifiez la branche `csharp`
   - Vérifiez que le dernier commit est présent

2. **Render déploie automatiquement** :
   - Si "Auto-Deploy" est activé, Render déploie automatiquement à chaque push
   - Attendez 2-5 minutes pour que le déploiement se termine

3. **Vérifiez le statut** :
   - Allez sur Render Dashboard : https://dashboard.render.com
   - Cliquez sur votre service `brasil-burger-csharp`
   - Vérifiez l'onglet "Events" ou "Logs" pour voir le déploiement en cours

---

## ✅ Méthode 2 : Redéploiement Manuel

### Si Auto-Deploy n'est pas activé ou si vous voulez forcer un redéploiement

1. **Connectez-vous à Render** :
   - Allez sur : https://dashboard.render.com
   - Connectez-vous avec votre compte GitHub

2. **Accédez à votre service** :
   - Cliquez sur votre service `brasil-burger-csharp` (ou le nom de votre service)

3. **Lancez le redéploiement manuel** :
   - Dans le menu en haut à droite, cliquez sur **"Manual Deploy"**
   - Sélectionnez **"Deploy latest commit"**
   - Render va redéployer votre application avec le dernier code de GitHub

4. **Surveillez le déploiement** :
   - Allez dans l'onglet **"Logs"**
   - Vous verrez le processus de build et de démarrage
   - Attendez que le statut passe à **"Live"** (vert)

---

## ✅ Méthode 3 : Redéploiement depuis GitHub (Push)

### Si vous avez fait des modifications locales

1. **Vérifiez vos modifications** :
   ```bash
   git status
   ```

2. **Ajoutez vos fichiers** :
   ```bash
   git add .
   ```

3. **Créez un commit** :
   ```bash
   git commit -m "Description de vos modifications"
   ```

4. **Poussez sur GitHub** :
   ```bash
   git push origin csharp
   ```

5. **Render déploiera automatiquement** (si Auto-Deploy est activé)

---

## 🔍 Vérifier le Statut du Déploiement

### Dans Render Dashboard

1. **Onglet "Events"** :
   - Affiche l'historique des déploiements
   - Statut : "Building", "Deploying", "Live", ou "Failed"

2. **Onglet "Logs"** :
   - Affiche les logs en temps réel
   - Cherchez les erreurs éventuelles

3. **Onglet "Metrics"** :
   - Affiche les métriques de performance

---

## ⚠️ Problèmes Courants

### Le déploiement ne démarre pas

1. **Vérifiez Auto-Deploy** :
   - Settings → Build & Deploy
   - Assurez-vous que "Auto-Deploy" est sur "Yes"

2. **Vérifiez la branche** :
   - Settings → Build & Deploy
   - Assurez-vous que la branche est `csharp`

### Le déploiement échoue

1. **Vérifiez les logs** :
   - Onglet "Logs" → Cherchez les erreurs
   - Erreurs courantes :
     - Erreurs de build (compilation)
     - Erreurs de connexion à la base de données
     - Variables d'environnement manquantes

2. **Vérifiez les variables d'environnement** :
   - Settings → Environment
   - Vérifiez que toutes les variables sont présentes :
     - `ConnectionStrings__DefaultConnection`
     - `Cloudinary__CloudName`
     - `Cloudinary__ApiKey`
     - `Cloudinary__ApiSecret`

---

## 📝 Checklist de Redéploiement

- [ ] Modifications poussées sur GitHub (branche `csharp`)
- [ ] Auto-Deploy activé dans Render
- [ ] Variables d'environnement configurées
- [ ] Logs vérifiés pour les erreurs
- [ ] Statut "Live" confirmé
- [ ] Application testée sur l'URL Render

---

## 🎯 Étapes Rapides

1. **GitHub** : Vérifiez que le code est poussé
2. **Render Dashboard** : Allez sur votre service
3. **Manual Deploy** : Cliquez sur "Manual Deploy" → "Deploy latest commit"
4. **Attendez** : 2-5 minutes
5. **Testez** : Allez sur votre URL Render

---

**Date** : Décembre 2025

