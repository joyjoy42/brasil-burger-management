# Brasil Burger Management

Projet Semestre 1 : L3 ISM  
Gestion de commandes et livraisons pour le restaurant Brasil Burger.

Ce dépôt contient la modélisation et les trois implémentations qui partagent la même base de données :
- Branches :
  - `modelisation` — UML, MLD, maquettes Figma, scripts SQL.
  - `java` — application Java console (fonctionnalités de base).
  - `csharp` — application C# ASP.NET MVC (client).
  - `symfony` — application Symfony (gestionnaire : commandes, suivi, statistiques).

Livrables et dates (originel) :
- Livrable 1 — 2025-12-14 : modelisation + java
- Livrable 2 — 2025-12-20 : csharp MVC
- Livrable 3 — 2025-12-30 : symfony

Organisation recommandée :
- `db/schema.sql` : script SQL principal (BD partagée).
- `modelisation/` : diagrammes (Use Case, Classe, Séquence), MLD, maquettes.
- `docs/` : instructions de déploiement, liens Figma.

Workflow Git :
- Commit par fonctionnalité. Message : `Feature(menu): Créer un menu`
- Push sur la branche correspondante puis déploiement depuis Render.

Prochaines étapes suggérées :
1. Confirmer que je crée le fichier `db/schema.sql` initial et `README.md`.
2. Si oui, voulez-vous que je génère aussi les issues GitHub (liste des tâches), ou préférez créer vous-même les issues ?
