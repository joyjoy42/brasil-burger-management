# Configuration Cloudinary pour Brasil Burger

## Étape 1 : Obtenir vos credentials Cloudinary

1. Allez sur https://cloudinary.com et connectez-vous (ou créez un compte gratuit)
2. Dans votre Dashboard, vous trouverez :
   - **Cloud Name** (ex: `dxxxxxxxx`)
   - **API Key** (ex: `123456789012345`)
   - **API Secret** (ex: `abcdefghijklmnopqrstuvwxyz`)

## Étape 2 : Configurer les credentials

Ajoutez vos credentials dans `appsettings.json` :

```json
"Cloudinary": {
  "CloudName": "VOTRE_CLOUD_NAME",
  "ApiKey": "VOTRE_API_KEY",
  "ApiSecret": "VOTRE_API_SECRET"
}
```

## Étape 3 : Utiliser le script d'upload

Une fois les credentials configurés, le script `UploadImagesToCloudinary.ps1` uploadera automatiquement toutes vos images et mettra à jour la base de données.

## Avantages de Cloudinary

✅ **CDN Global** : Images servies rapidement partout dans le monde
✅ **Optimisation Automatique** : Compression et redimensionnement automatiques
✅ **Transformations** : Possibilité de redimensionner, recadrer, etc. via URL
✅ **Gratuit** : Plan gratuit jusqu'à 25 GB de stockage et 25 GB de bande passante/mois
✅ **Backup** : Vos images sont sauvegardées et toujours accessibles

## Structure des URLs Cloudinary

Format : `https://res.cloudinary.com/{cloud_name}/image/upload/{folder}/{filename}`

Exemple : `https://res.cloudinary.com/dxxxxxxxx/image/upload/brasil-burger/burger-classique.jpg`

## Prochaines étapes

1. Configurez vos credentials dans `appsettings.json`
2. Exécutez le script d'upload
3. L'application sera automatiquement mise à jour pour utiliser les URLs Cloudinary

