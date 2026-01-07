# Use Case Diagram - Brasil Burger

```mermaid
useCaseDiagram
    actor Client
    actor Gestionnaire
    actor Livreur

    package "Catalogue & Menus" {
        usecase "Voir le catalogue" as UC1
        usecase "Voir détails produit" as UC2
        usecase "Gérer le catalogue (CRUD)" as UC3
    }

    package "Commandes" {
        usecase "Passer une commande" as UC4
        usecase "Payer la commande" as UC5
        usecase "Suivre l'état de commande" as UC6
        usecase "Lister les commandes" as UC7
        usecase "Annuler une commande" as UC8
        usecase "Modifier l'état (Prête/Finie)" as UC9
    }

    package "Livraisons" {
        usecase "Affecter à un livreur" as UC10
        usecase "Livrer une commande" as UC11
    }

    package "Statistiques" {
        usecase "Voir les statistiques journalières" as UC12
    }

    Client --> UC1
    Client --> UC2
    Client --> UC4
    Client --> UC5
    Client --> UC6

    Gestionnaire --> UC3
    Gestionnaire --> UC7
    Gestionnaire --> UC8
    Gestionnaire --> UC9
    Gestionnaire --> UC10
    Gestionnaire --> UC12

    Livreur --> UC11
    UC11 ..> UC9 : <<extend>>
```
