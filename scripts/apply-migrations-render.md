# 🔧 Appliquer les Migrations sur Render

## Méthode 1 : Via Render Shell (Recommandé)

### Étape 1 : Accéder au Shell

1. **Render Dashboard** : https://dashboard.render.com
2. **Service** : `brasil-burger-csharp`
3. **Onglet** : **"Shell"**

### Étape 2 : Exécuter la Commande

Dans le shell Render, exécutez :

```bash
dotnet ef database update
```

**Résultat attendu** :
```
Done.
```

### Étape 3 : Vérifier

Si les migrations sont appliquées, vous verrez :
- ✅ "Done."
- ✅ Pas d'erreur

Si erreur, vous verrez :
- ❌ "Table does not exist" → Les migrations n'ont pas été créées
- ❌ "Connection failed" → Problème de connexion DB

---

## Méthode 2 : En Local avec Connexion Neon

### Étape 1 : Se Placer dans le Dossier du Projet C#

```bash
cd BrasilBurger.Web
# ou le dossier où se trouve votre .csproj
```

### Étape 2 : Appliquer les Migrations

```bash
dotnet ef database update --connection "Host=ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech;Database=neondb;Username=neondb_owner;Password=npg_Q28lkcThzxRG;SSL Mode=Require;Trust Server Certificate=true"
```

---

## Méthode 3 : Via Script Automatique

Si vous avez accès au repository en local :

```bash
# Linux/Mac
chmod +x scripts/apply-migrations.sh
./scripts/apply-migrations.sh

# Windows (PowerShell)
.\scripts\apply-migrations.sh
```

---

## ⚠️ Si les Migrations N'Existent Pas

Si vous obtenez "No migrations found", vous devez créer les migrations :

```bash
dotnet ef migrations add InitialMigration
dotnet ef database update
```

---

## ✅ Vérification

Après avoir appliqué les migrations, vérifiez que les tables existent :

```sql
-- Via psql ou Render Shell
\dt
```

Vous devriez voir :
- Burgers
- Menus
- Complements
- Clients
- Commandes
- LigneCommandes
- Paiements
- etc.

---

**Date** : Décembre 2025

