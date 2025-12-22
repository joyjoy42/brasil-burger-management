# 📋 Organisation du Projet Brasil Burger selon le Cahier des Charges

## 🎯 Structure des Branches GitHub

### Branche `modelisation`
**Contenu** :
- ✅ Diagramme Use Case
- ✅ Diagramme de Classe
- ✅ Diagramme de Séquence (conception)
- ✅ Maquettes Figma
- ✅ MLD (Modèle Logique de Données)
- ✅ Script SQL de création de la base de données

**Livrable** : 14/12/2025

---

### Branche `java`
**Contenu** :
- ✅ Application console Java
- ✅ Création des ressources :
  - Burgers (ajouter, modifier, archiver)
  - Menus (ajouter, modifier, archiver)
  - Compléments (ajouter, modifier, archiver)
- ✅ Connexion à la base de données PostgreSQL partagée

**Livrable** : 14/12/2025 + Déploiement

---

### Branche `csharp`
**Contenu** :
- ✅ Application ASP.NET MVC
- ✅ Fonctionnalités Client :
  - Catalogue de burgers et menus
  - Détails burger/menu
  - Commande (burger/menu)
  - Sélection compléments
  - Type de livraison (sur place / à emporter / livraison)
  - Panier
  - Authentification (inscription/connexion)
  - Suivi des commandes
  - Paiement (Wave/OM)
  - Filtrage catalogue (menu/burger)

**Livrable** : 20/12/2025 + Déploiement

---

### Branche `symfony`
**Contenu** :
- ✅ Application Symfony
- ✅ Fonctionnalités Gestionnaire :
  - Authentification gestionnaire
  - Ajouter/Modifier/Archiver burgers
  - Ajouter/Modifier/Archiver menus
  - Ajouter/Modifier/Archiver compléments
  - Lister les commandes
  - Annuler une commande (par nom, prénom, téléphone)
  - Changer l'état de commande (Terminer)
  - Gestion livraisons (regrouper par zone, affecter livreur)
  - Filtrage commandes (burger/menu, date, état, client)
  - Statistiques :
    - Commandes en cours de la journée
    - Commandes validées de la journée
    - Recettes journalières
    - Burgers au menu les plus vendus de la journée
    - Commandes annulées du jour

**Livrable** : 30/12/2025 + Déploiement

---

## 🗄️ Base de Données Partagée

**PostgreSQL (Neon)** - Créée manuellement (pas de migration)

**Tables** :
- Burgers
- Menus
- Complements
- Clients
- Commandes
- LigneCommandes
- Paiements
- Zones
- Livreurs
- MenuBurgers (table de jointure)
- MenuComplements (table de jointure)

**Script SQL** : Dans la branche `modelisation`

---

## 🚀 Déploiement

**Plateforme** : Render.com (https://render.com/)

**Déploiement depuis** :
- Branche `java` → Service Render (si nécessaire)
- Branche `csharp` → Service Render Web
- Branche `symfony` → Service Render Web

**Configuration** :
- Chaque service se connecte à la même base PostgreSQL (Neon)
- Variables d'environnement pour les credentials

---

## 📝 Règles de Commit

**Un commit par fonctionnalité** :
- Exemple : `feat: Créer un menu`
- Exemple : `feat: Lister les menus`
- Exemple : `feat: Authentification client`

**Push à la fin de chaque projet** :
- Après avoir terminé toutes les fonctionnalités d'un projet
- Avant le déploiement

---

## ✅ Checklist de Réorganisation

- [ ] Vérifier que la branche `modelisation` contient tous les diagrammes
- [ ] Vérifier que la branche `java` contient uniquement l'application console
- [ ] Vérifier que la branche `csharp` contient uniquement l'application client
- [ ] Vérifier que la branche `symfony` est prête pour le développement
- [ ] S'assurer que la base de données est partagée entre les 3 projets
- [ ] Configurer le déploiement Render pour chaque branche
- [ ] Documenter chaque branche avec un README approprié

---

**Date** : Décembre 2025

