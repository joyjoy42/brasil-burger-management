# ⚡ Solution Rapide - Erreur 500 Internal Server Error

## 🎯 Solution en 3 Étapes (5 minutes)

### Étape 1 : Vérifier les Logs (2 min)

1. **Render Dashboard** → Service `brasil-burger-csharp` → **"Logs"**
2. **Cherchez les erreurs** en rouge
3. **Notez le message d'erreur** exact

### Étape 2 : Appliquer les Migrations (1 min)

**Via Render Shell** :
1. Service → **"Shell"**
2. Exécutez :
   ```bash
   dotnet ef database update
   ```

### Étape 3 : Vérifier les Variables d'Environnement (2 min)

**Render Dashboard** → Service → **"Environment"**

Vérifiez que ces variables existent :

✅ `ASPNETCORE_ENVIRONMENT` = `Production`  
✅ `ASPNETCORE_URLS` = `http://0.0.0.0:10000`  
✅ `ConnectionStrings__DefaultConnection` = (connexion Neon complète)  
✅ `Cloudinary__CloudName` = `dbkji1d1j`  
✅ `Cloudinary__ApiKey` = `166294258315442`  
✅ `Cloudinary__ApiSecret` = `9bpSi55tkiP5IZnwNpHrMuw-Qsc`  

**⚠️ Important** : Utilisez `__` (double underscore) pour les sections imbriquées !

---

## 🔍 Erreurs Courantes

### "Table does not exist"
→ **Solution** : `dotnet ef database update`

### "Unable to connect to database"
→ **Solution** : Vérifiez `ConnectionStrings__DefaultConnection`

### "Cloudinary error"
→ **Solution** : Vérifiez les identifiants Cloudinary

---

## 📞 Besoin d'Aide ?

**Partagez-moi** :
1. Le message d'erreur exact des logs Render
2. Les variables d'environnement configurées
3. Le résultat de `dotnet ef database update`

Et je vous aiderai à résoudre le problème spécifique !

