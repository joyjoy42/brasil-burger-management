# 📋 Plan de Réorganisation du Projet Brasil Burger

## 🎯 Objectif

Réorganiser le projet selon le cahier des charges avec 4 branches distinctes :
- `modelisation` : Diagrammes, maquettes, MLD, script SQL
- `java` : Application console pour création de ressources
- `csharp` : Application ASP.NET MVC pour fonctionnalités client
- `symfony` : Application Symfony pour fonctionnalités gestionnaire

---

## 📁 Structure Cible par Branche

### Branche `modelisation`
```
modelisation/
├── README.md
├── Diagrammes/
│   ├── UseCase_Diagram.png
│   ├── Class_Diagram.png
│   └── Sequence_Diagram.png
├── Maquettes/
│   └── (liens ou fichiers Figma)
├── MLD/
│   └── MLD_BrasilBurger.md
└── Database/
    └── script_sql_creation.sql
```

### Branche `java`
```
java/
├── README.md
├── BrasilBurger_Java/
│   ├── src/
│   ├── pom.xml
│   └── database.properties (template)
└── DEPLOYMENT.md (si nécessaire)
```

### Branche `csharp`
```
csharp/
├── README.md
├── BrasilBurger.Web.csproj
├── Program.cs
├── Controllers/
├── Models/
├── Views/
├── Services/
├── Data/
├── Migrations/
├── wwwroot/
├── appsettings.Example.json
├── render.yaml
└── Dockerfile
```

### Branche `symfony`
```
symfony/
├── README.md
├── (structure Symfony standard)
└── render.yaml (pour déploiement)
```

---

## 🔄 Étapes de Réorganisation

### Étape 1 : Nettoyer la branche `csharp`
- [x] Supprimer les fichiers .md (sauf README.md)
- [ ] Supprimer le dossier `BrasilBurger_Java/` (doit être dans branche `java`)
- [ ] Garder uniquement les fichiers C# ASP.NET MVC
- [ ] Vérifier que `render.yaml` est correct

### Étape 2 : Vérifier la branche `java`
- [ ] S'assurer qu'elle contient uniquement le projet Java
- [ ] Vérifier la connexion à la base de données
- [ ] Ajouter README.md spécifique

### Étape 3 : Vérifier la branche `modelisation`
- [ ] Vérifier que tous les diagrammes sont présents
- [ ] Vérifier le script SQL
- [ ] Ajouter README.md

### Étape 4 : Préparer la branche `symfony`
- [ ] Créer la structure Symfony de base
- [ ] Configurer la connexion à la base de données
- [ ] Ajouter README.md

### Étape 5 : Mettre à jour README.md principal
- [ ] Documenter la structure des 4 branches
- [ ] Ajouter les instructions de déploiement
- [ ] Documenter les dates de livraison

---

## ✅ Checklist de Validation

### Branche `csharp`
- [ ] Contient uniquement les fichiers C# ASP.NET MVC
- [ ] Pas de fichiers Java
- [ ] `render.yaml` configuré pour déploiement
- [ ] README.md à jour

### Branche `java`
- [ ] Contient uniquement le projet Java console
- [ ] Pas de fichiers C# ou Symfony
- [ ] Connexion DB configurée
- [ ] README.md à jour

### Branche `modelisation`
- [ ] Tous les diagrammes présents
- [ ] Script SQL complet
- [ ] README.md à jour

### Branche `symfony`
- [ ] Structure Symfony créée
- [ ] Connexion DB configurée
- [ ] README.md à jour

---

**Date** : Décembre 2025


