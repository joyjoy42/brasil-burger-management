# 🔐 Guide de Connexion à Render.com

## 🎯 Qu'est-ce que Render ?

Render est une plateforme cloud qui permet de déployer facilement des applications web, des bases de données et des services backend.

**URL** : https://render.com

---

## 📝 Étape 1 : Créer un Compte

### Option A : Inscription avec Email

1. **Allez sur** : https://render.com
2. **Cliquez sur** **"Get Started for Free"** ou **"Sign Up"** (en haut à droite)
3. **Remplissez le formulaire** :
   - Email
   - Mot de passe
   - Confirmez le mot de passe
4. **Cliquez sur** **"Create Account"**
5. **Vérifiez votre email** (cliquez sur le lien de confirmation)

### Option B : Inscription avec GitHub (Recommandé)

1. **Allez sur** : https://render.com
2. **Cliquez sur** **"Sign Up with GitHub"**
3. **Autorisez Render** à accéder à votre compte GitHub
4. **C'est tout !** Votre compte est créé automatiquement

**Avantages** :
- ✅ Connexion automatique à vos repositories GitHub
- ✅ Déploiement automatique depuis GitHub
- ✅ Pas besoin de gérer les credentials séparément

---

## 🔑 Étape 2 : Se Connecter

### Connexion avec Email

1. **Allez sur** : https://render.com
2. **Cliquez sur** **"Sign In"** (en haut à droite)
3. **Entrez** votre email et mot de passe
4. **Cliquez sur** **"Sign In"**

### Connexion avec GitHub

1. **Allez sur** : https://render.com
2. **Cliquez sur** **"Sign In with GitHub"**
3. **Autorisez Render** si demandé
4. **Vous êtes connecté !**

---

## 🚀 Étape 3 : Connecter votre Repository GitHub

### Méthode 1 : Via Render Dashboard

1. **Une fois connecté**, vous verrez le **Dashboard**
2. **Cliquez sur** **"New +"** (en haut à droite)
3. **Sélectionnez** **"Web Service"**
4. **Connectez votre repository** :
   - Si vous êtes connecté avec GitHub, vos repositories apparaîtront automatiquement
   - **Sélectionnez** : `joyjoy42/brasil-burger-management`
   - **Sélectionnez la branche** : `csharp` (pour C#) ou `symfony` (pour Symfony)

### Méthode 2 : Via render.yaml (Automatique)

Si votre repository contient un fichier `render.yaml`, Render le détectera automatiquement :

1. **Dashboard** → **"New +"** → **"Web Service"**
2. **Sélectionnez** votre repository
3. Render détectera automatiquement `render.yaml` et configurera le service

---

## ⚙️ Étape 4 : Configuration du Service

### Pour le Projet C# (Branche `csharp`)

1. **Repository** : `joyjoy42/brasil-burger-management`
2. **Branche** : `csharp`
3. **Environment** : `.NET` ou `dotnet`
4. **Build Command** : 
   ```
   dotnet restore BrasilBurger.Web.csproj && dotnet publish BrasilBurger.Web.csproj -c Release -o ./publish
   ```
5. **Start Command** :
   ```
   dotnet ./publish/BrasilBurger.Web.dll
   ```

### Variables d'Environnement

Dans **Settings** → **Environment**, ajoutez :

| Variable | Valeur |
|----------|--------|
| `ASPNETCORE_ENVIRONMENT` | `Production` |
| `ASPNETCORE_URLS` | `http://0.0.0.0:10000` |
| `ConnectionStrings__DefaultConnection` | `Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true` |
| `Cloudinary__CloudName` | `dbkji1d1j` |
| `Cloudinary__ApiKey` | `166294258315442` |
| `Cloudinary__ApiSecret` | `9bpSi55tkiP5IZnwNpHrMuw-Qsc` |

---

## 📋 Checklist de Connexion

- [ ] Compte Render créé (email ou GitHub)
- [ ] Email vérifié (si inscription par email)
- [ ] Connecté au Dashboard Render
- [ ] Repository GitHub connecté
- [ ] Service créé (Web Service)
- [ ] Variables d'environnement configurées
- [ ] Déploiement réussi

---

## 🔍 Navigation dans Render Dashboard

### Menu Principal

```
Dashboard
├── Services          ← Vos applications déployées
├── Databases         ← Bases de données (si vous en créez)
├── Static Sites      ← Sites statiques
└── Settings          ← Paramètres du compte
```

### Dans un Service

```
Service: brasil-burger-csharp
├── Overview          ← Vue d'ensemble
├── Logs              ← Logs en temps réel
├── Events            ← Historique des événements
├── Settings          ← Configuration
│   ├── General       ← Nom, région, plan
│   ├── Environment   ← Variables d'environnement
│   ├── Build & Deploy ← Commandes de build
│   └── ...
└── Manual Deploy     ← Déploiement manuel
```

---

## 🆘 Problèmes de Connexion

### Erreur : "Invalid credentials"

**Solution** :
1. Vérifiez votre email et mot de passe
2. Utilisez "Forgot Password" pour réinitialiser
3. Ou connectez-vous avec GitHub

### Erreur : "Repository not found"

**Solution** :
1. Vérifiez que le repository est public OU
2. Autorisez Render à accéder à vos repositories privés dans les paramètres GitHub

### Erreur : "Permission denied"

**Solution** :
1. Vérifiez que vous êtes le propriétaire du repository
2. Ou que vous avez les droits d'administration

---

## 💡 Astuces

### Connexion GitHub (Recommandé)

**Avantages** :
- ✅ Déploiement automatique à chaque push
- ✅ Pas besoin de gérer les credentials
- ✅ Intégration native avec GitHub

**Comment faire** :
1. **Render Dashboard** → **Account Settings**
2. **GitHub** → **Connect GitHub Account**
3. **Autorisez** Render à accéder à vos repositories

### Plan Gratuit

Render offre un **plan gratuit** avec :
- ✅ 750 heures de service par mois
- ✅ Déploiement automatique
- ✅ HTTPS automatique
- ⚠️ Service s'endort après 15 minutes d'inactivité (gratuit)

---

## 🔗 Liens Utiles

- **Render Dashboard** : https://dashboard.render.com
- **Documentation Render** : https://render.com/docs
- **Support Render** : https://render.com/support

---

## 📝 Résumé Rapide

1. **Allez sur** https://render.com
2. **Cliquez sur** "Sign Up" ou "Sign In"
3. **Connectez-vous** avec GitHub (recommandé) ou Email
4. **Dashboard** → "New +" → "Web Service"
5. **Sélectionnez** votre repository et branche
6. **Configurez** les variables d'environnement
7. **Déployez !**

---

**Date** : Décembre 2025

