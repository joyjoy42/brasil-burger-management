package com.brasilburger.ui;

import com.brasilburger.models.Burger;
import com.brasilburger.models.Menu;
import com.brasilburger.models.Complement;
import com.brasilburger.services.BurgerService;
import com.brasilburger.services.MenuService;
import com.brasilburger.services.ComplementService;
import java.util.ArrayList;
import java.util.List;
import java.util.Scanner;

public class MenuConsole {
    private Scanner scanner;
    private BurgerService burgerService;
    private MenuService menuService;
    private ComplementService complementService;
    
    public MenuConsole(BurgerService burgerService, MenuService menuService, ComplementService complementService) {
        this.scanner = new Scanner(System.in);
        this.burgerService = burgerService;
        this.menuService = menuService;
        this.complementService = complementService;
    }
    
    public void afficherMenuPrincipal() {
        boolean continuer = true;
        
        while (continuer) {
            System.out.println("\n╔════════════════════════════════════════════════════════╗");
            System.out.println("║     BRASIL BURGER - GESTION DES RESSOURCES            ║");
            System.out.println("╚════════════════════════════════════════════════════════╝");
            System.out.println("\n1. Gestion des Burgers");
            System.out.println("2. Gestion des Menus");
            System.out.println("3. Gestion des Compléments");
            System.out.println("0. Quitter");
            System.out.print("\nVotre choix : ");
            
            int choix = lireEntier();
            
            switch (choix) {
                case 1:
                    menuBurgers();
                    break;
                case 2:
                    menuMenus();
                    break;
                case 3:
                    menuComplements();
                    break;
                case 0:
                    continuer = false;
                    System.out.println("\nAu revoir !");
                    break;
                default:
                    System.out.println("\n❌ Choix invalide !");
            }
        }
    }
    
    // ========== MENU BURGERS ==========
    
    private void menuBurgers() {
        boolean continuer = true;
        
        while (continuer) {
            System.out.println("\n╔════════════════════════════════════════════════════════╗");
            System.out.println("║              GESTION DES BURGERS                       ║");
            System.out.println("╚════════════════════════════════════════════════════════╝");
            System.out.println("\n1. Ajouter un burger");
            System.out.println("2. Modifier un burger");
            System.out.println("3. Archiver un burger");
            System.out.println("4. Désarchiver un burger");
            System.out.println("5. Lister tous les burgers");
            System.out.println("6. Lister les burgers actifs");
            System.out.println("7. Rechercher un burger");
            System.out.println("0. Retour");
            System.out.print("\nVotre choix : ");
            
            int choix = lireEntier();
            
            switch (choix) {
                case 1:
                    ajouterBurger();
                    break;
                case 2:
                    modifierBurger();
                    break;
                case 3:
                    archiverBurger();
                    break;
                case 4:
                    desarchiverBurger();
                    break;
                case 5:
                    listerTousBurgers();
                    break;
                case 6:
                    listerBurgersActifs();
                    break;
                case 7:
                    rechercherBurger();
                    break;
                case 0:
                    continuer = false;
                    break;
                default:
                    System.out.println("\n❌ Choix invalide !");
            }
        }
    }
    
    private void ajouterBurger() {
        System.out.println("\n--- Ajouter un Burger ---");
        System.out.print("Nom : ");
        String nom = scanner.nextLine();
        System.out.print("Prix (FCFA) : ");
        double prix = lireDouble();
        System.out.print("Image (nom du fichier) : ");
        String image = scanner.nextLine();
        
        Burger burger = new Burger(0, nom, prix, image, false);
        if (burgerService.ajouterBurger(burger)) {
            System.out.println("\n✅ Burger ajouté avec succès ! (ID: " + burger.getId() + ")");
        } else {
            System.out.println("\n❌ Erreur lors de l'ajout du burger.");
        }
    }
    
    private void modifierBurger() {
        System.out.println("\n--- Modifier un Burger ---");
        System.out.print("ID du burger à modifier : ");
        int id = lireEntier();
        
        if (burgerService.trouverBurger(id).isEmpty()) {
            System.out.println("\n❌ Burger introuvable !");
            return;
        }
        
        System.out.print("Nouveau nom : ");
        String nom = scanner.nextLine();
        System.out.print("Nouveau prix (FCFA) : ");
        double prix = lireDouble();
        System.out.print("Nouvelle image : ");
        String image = scanner.nextLine();
        
        if (burgerService.modifierBurger(id, nom, prix, image)) {
            System.out.println("\n✅ Burger modifié avec succès !");
        } else {
            System.out.println("\n❌ Erreur lors de la modification !");
        }
    }
    
    private void archiverBurger() {
        System.out.println("\n--- Archiver un Burger ---");
        System.out.print("ID du burger à archiver : ");
        int id = lireEntier();
        
        if (burgerService.archiverBurger(id)) {
            System.out.println("\n✅ Burger archivé avec succès !");
        } else {
            System.out.println("\n❌ Burger introuvable !");
        }
    }
    
    private void desarchiverBurger() {
        System.out.println("\n--- Désarchiver un Burger ---");
        System.out.print("ID du burger à désarchiver : ");
        int id = lireEntier();
        
        if (burgerService.desarchiverBurger(id)) {
            System.out.println("\n✅ Burger désarchivé avec succès !");
        } else {
            System.out.println("\n❌ Burger introuvable !");
        }
    }
    
    private void listerTousBurgers() {
        System.out.println("\n--- Liste de tous les Burgers ---");
        List<Burger> burgers = burgerService.listerBurgers();
        if (burgers.isEmpty()) {
            System.out.println("Aucun burger enregistré.");
        } else {
            burgers.forEach(b -> {
                String status = b.isArchive() ? " [ARCHIVÉ]" : " [ACTIF]";
                System.out.println("ID: " + b.getId() + " | " + b.getNom() + " | " + b.getPrix() + " FCFA" + status);
            });
        }
    }
    
    private void listerBurgersActifs() {
        System.out.println("\n--- Liste des Burgers Actifs ---");
        List<Burger> burgers = burgerService.listerBurgersActifs();
        if (burgers.isEmpty()) {
            System.out.println("Aucun burger actif.");
        } else {
            burgers.forEach(b -> 
                System.out.println("ID: " + b.getId() + " | " + b.getNom() + " | " + b.getPrix() + " FCFA")
            );
        }
    }
    
    private void rechercherBurger() {
        System.out.println("\n--- Rechercher un Burger ---");
        System.out.print("Nom à rechercher : ");
        String nom = scanner.nextLine();
        List<Burger> resultats = burgerService.rechercherParNom(nom);
        
        if (resultats.isEmpty()) {
            System.out.println("Aucun résultat trouvé.");
        } else {
            System.out.println("\nRésultats de la recherche :");
            resultats.forEach(b -> 
                System.out.println("ID: " + b.getId() + " | " + b.getNom() + " | " + b.getPrix() + " FCFA")
            );
        }
    }
    
    // ========== MENU MENUS ==========
    
    private void menuMenus() {
        boolean continuer = true;
        
        while (continuer) {
            System.out.println("\n╔════════════════════════════════════════════════════════╗");
            System.out.println("║              GESTION DES MENUS                         ║");
            System.out.println("╚════════════════════════════════════════════════════════╝");
            System.out.println("\n1. Ajouter un menu");
            System.out.println("2. Modifier un menu");
            System.out.println("3. Archiver un menu");
            System.out.println("4. Désarchiver un menu");
            System.out.println("5. Lister tous les menus");
            System.out.println("6. Lister les menus actifs");
            System.out.println("7. Voir les détails d'un menu");
            System.out.println("0. Retour");
            System.out.print("\nVotre choix : ");
            
            int choix = lireEntier();
            
            switch (choix) {
                case 1:
                    ajouterMenu();
                    break;
                case 2:
                    modifierMenu();
                    break;
                case 3:
                    archiverMenu();
                    break;
                case 4:
                    desarchiverMenu();
                    break;
                case 5:
                    listerTousMenus();
                    break;
                case 6:
                    listerMenusActifs();
                    break;
                case 7:
                    voirDetailsMenu();
                    break;
                case 0:
                    continuer = false;
                    break;
                default:
                    System.out.println("\n❌ Choix invalide !");
            }
        }
    }
    
    private void ajouterMenu() {
        System.out.println("\n--- Ajouter un Menu ---");
        System.out.print("Nom : ");
        String nom = scanner.nextLine();
        System.out.print("Image (nom du fichier) : ");
        String image = scanner.nextLine();
        
        // Sélectionner les burgers
        System.out.println("\nBurgers disponibles :");
        List<Burger> burgersActifs = burgerService.listerBurgersActifs();
        if (burgersActifs.isEmpty()) {
            System.out.println("❌ Aucun burger actif disponible !");
            return;
        }
        burgersActifs.forEach(b -> System.out.println("  " + b.getId() + ". " + b.getNom()));
        System.out.print("\nIDs des burgers (séparés par des virgules) : ");
        String burgersInput = scanner.nextLine();
        List<Burger> burgers = selectionnerBurgers(burgersInput);
        
        // Sélectionner les compléments
        System.out.println("\nCompléments disponibles :");
        List<Complement> complementsActifs = complementService.listerComplementsActifs();
        complementsActifs.forEach(c -> System.out.println("  " + c.getId() + ". " + c.getNom()));
        System.out.print("\nIDs des compléments (séparés par des virgules, ou vide) : ");
        String complementsInput = scanner.nextLine();
        List<Complement> complements = selectionnerComplements(complementsInput);
        
        Menu menu = new Menu(0, nom, image, burgers, complements, false);
        if (menuService.ajouterMenu(menu)) {
            double prixTotal = menuService.calculerPrixMenu(menu);
            System.out.println("\n✅ Menu ajouté avec succès ! (ID: " + menu.getId() + ")");
            System.out.println("💰 Prix total du menu : " + prixTotal + " FCFA");
        } else {
            System.out.println("\n❌ Erreur lors de l'ajout du menu.");
        }
    }
    
    private void modifierMenu() {
        System.out.println("\n--- Modifier un Menu ---");
        System.out.print("ID du menu à modifier : ");
        int id = lireEntier();
        
        if (menuService.trouverMenu(id).isEmpty()) {
            System.out.println("\n❌ Menu introuvable !");
            return;
        }
        
        System.out.print("Nouveau nom : ");
        String nom = scanner.nextLine();
        System.out.print("Nouvelle image : ");
        String image = scanner.nextLine();
        
        // Sélectionner les burgers
        System.out.println("\nBurgers disponibles :");
        burgerService.listerBurgersActifs().forEach(b -> System.out.println("  " + b.getId() + ". " + b.getNom()));
        System.out.print("\nIDs des burgers (séparés par des virgules) : ");
        String burgersInput = scanner.nextLine();
        List<Burger> burgers = selectionnerBurgers(burgersInput);
        
        // Sélectionner les compléments
        System.out.println("\nCompléments disponibles :");
        complementService.listerComplementsActifs().forEach(c -> System.out.println("  " + c.getId() + ". " + c.getNom()));
        System.out.print("\nIDs des compléments (séparés par des virgules, ou vide) : ");
        String complementsInput = scanner.nextLine();
        List<Complement> complements = selectionnerComplements(complementsInput);
        
        if (menuService.modifierMenu(id, nom, image, burgers, complements)) {
            System.out.println("\n✅ Menu modifié avec succès !");
        } else {
            System.out.println("\n❌ Erreur lors de la modification !");
        }
    }
    
    private void archiverMenu() {
        System.out.println("\n--- Archiver un Menu ---");
        System.out.print("ID du menu à archiver : ");
        int id = lireEntier();
        
        if (menuService.archiverMenu(id)) {
            System.out.println("\n✅ Menu archivé avec succès !");
        } else {
            System.out.println("\n❌ Menu introuvable !");
        }
    }
    
    private void desarchiverMenu() {
        System.out.println("\n--- Désarchiver un Menu ---");
        System.out.print("ID du menu à désarchiver : ");
        int id = lireEntier();
        
        if (menuService.desarchiverMenu(id)) {
            System.out.println("\n✅ Menu désarchivé avec succès !");
        } else {
            System.out.println("\n❌ Menu introuvable !");
        }
    }
    
    private void listerTousMenus() {
        System.out.println("\n--- Liste de tous les Menus ---");
        List<Menu> menus = menuService.listerMenus();
        if (menus.isEmpty()) {
            System.out.println("Aucun menu enregistré.");
        } else {
            menus.forEach(m -> {
                String status = m.isArchive() ? " [ARCHIVÉ]" : " [ACTIF]";
                double prix = menuService.calculerPrixMenu(m);
                System.out.println("ID: " + m.getId() + " | " + m.getNom() + " | " + prix + " FCFA" + status);
            });
        }
    }
    
    private void listerMenusActifs() {
        System.out.println("\n--- Liste des Menus Actifs ---");
        List<Menu> menus = menuService.listerMenusActifs();
        if (menus.isEmpty()) {
            System.out.println("Aucun menu actif.");
        } else {
            menus.forEach(m -> {
                double prix = menuService.calculerPrixMenu(m);
                System.out.println("ID: " + m.getId() + " | " + m.getNom() + " | " + prix + " FCFA");
            });
        }
    }
    
    private void voirDetailsMenu() {
        System.out.println("\n--- Détails d'un Menu ---");
        System.out.print("ID du menu : ");
        int id = lireEntier();
        
        var menuOpt = menuService.trouverMenu(id);
        if (menuOpt.isEmpty()) {
            System.out.println("\n❌ Menu introuvable !");
            return;
        }
        
        Menu menu = menuOpt.get();
        System.out.println("\n📋 Menu : " + menu.getNom());
        System.out.println("🖼️  Image : " + menu.getImage());
        System.out.println("\n🍔 Burgers :");
        if (menu.getBurgers() != null && !menu.getBurgers().isEmpty()) {
            menu.getBurgers().forEach(b -> 
                System.out.println("  - " + b.getNom() + " (" + b.getPrix() + " FCFA)")
            );
        } else {
            System.out.println("  Aucun burger");
        }
        System.out.println("\n🍟 Compléments :");
        if (menu.getComplements() != null && !menu.getComplements().isEmpty()) {
            menu.getComplements().forEach(c -> 
                System.out.println("  - " + c.getNom() + " (" + c.getPrix() + " FCFA)")
            );
        } else {
            System.out.println("  Aucun complément");
        }
        double prixTotal = menuService.calculerPrixMenu(menu);
        System.out.println("\n💰 Prix total : " + prixTotal + " FCFA");
    }
    
    // ========== MENU COMPLÉMENTS ==========
    
    private void menuComplements() {
        boolean continuer = true;
        
        while (continuer) {
            System.out.println("\n╔════════════════════════════════════════════════════════╗");
            System.out.println("║           GESTION DES COMPLÉMENTS                     ║");
            System.out.println("╚════════════════════════════════════════════════════════╝");
            System.out.println("\n1. Ajouter un complément");
            System.out.println("2. Modifier un complément");
            System.out.println("3. Archiver un complément");
            System.out.println("4. Désarchiver un complément");
            System.out.println("5. Lister tous les compléments");
            System.out.println("6. Lister les compléments actifs");
            System.out.println("7. Rechercher un complément");
            System.out.println("0. Retour");
            System.out.print("\nVotre choix : ");
            
            int choix = lireEntier();
            
            switch (choix) {
                case 1:
                    ajouterComplement();
                    break;
                case 2:
                    modifierComplement();
                    break;
                case 3:
                    archiverComplement();
                    break;
                case 4:
                    desarchiverComplement();
                    break;
                case 5:
                    listerTousComplements();
                    break;
                case 6:
                    listerComplementsActifs();
                    break;
                case 7:
                    rechercherComplement();
                    break;
                case 0:
                    continuer = false;
                    break;
                default:
                    System.out.println("\n❌ Choix invalide !");
            }
        }
    }
    
    private void ajouterComplement() {
        System.out.println("\n--- Ajouter un Complément ---");
        System.out.print("Nom : ");
        String nom = scanner.nextLine();
        System.out.print("Prix (FCFA) : ");
        double prix = lireDouble();
        System.out.print("Image (nom du fichier) : ");
        String image = scanner.nextLine();
        
        Complement complement = new Complement(0, nom, prix, image, false);
        if (complementService.ajouterComplement(complement)) {
            System.out.println("\n✅ Complément ajouté avec succès ! (ID: " + complement.getId() + ")");
        } else {
            System.out.println("\n❌ Erreur lors de l'ajout du complément.");
        }
    }
    
    private void modifierComplement() {
        System.out.println("\n--- Modifier un Complément ---");
        System.out.print("ID du complément à modifier : ");
        int id = lireEntier();
        
        if (complementService.trouverComplement(id).isEmpty()) {
            System.out.println("\n❌ Complément introuvable !");
            return;
        }
        
        System.out.print("Nouveau nom : ");
        String nom = scanner.nextLine();
        System.out.print("Nouveau prix (FCFA) : ");
        double prix = lireDouble();
        System.out.print("Nouvelle image : ");
        String image = scanner.nextLine();
        
        if (complementService.modifierComplement(id, nom, prix, image)) {
            System.out.println("\n✅ Complément modifié avec succès !");
        } else {
            System.out.println("\n❌ Erreur lors de la modification !");
        }
    }
    
    private void archiverComplement() {
        System.out.println("\n--- Archiver un Complément ---");
        System.out.print("ID du complément à archiver : ");
        int id = lireEntier();
        
        if (complementService.archiverComplement(id)) {
            System.out.println("\n✅ Complément archivé avec succès !");
        } else {
            System.out.println("\n❌ Complément introuvable !");
        }
    }
    
    private void desarchiverComplement() {
        System.out.println("\n--- Désarchiver un Complément ---");
        System.out.print("ID du complément à désarchiver : ");
        int id = lireEntier();
        
        if (complementService.desarchiverComplement(id)) {
            System.out.println("\n✅ Complément désarchivé avec succès !");
        } else {
            System.out.println("\n❌ Complément introuvable !");
        }
    }
    
    private void listerTousComplements() {
        System.out.println("\n--- Liste de tous les Compléments ---");
        List<Complement> complements = complementService.listerComplements();
        if (complements.isEmpty()) {
            System.out.println("Aucun complément enregistré.");
        } else {
            complements.forEach(c -> {
                String status = c.isArchive() ? " [ARCHIVÉ]" : " [ACTIF]";
                System.out.println("ID: " + c.getId() + " | " + c.getNom() + " | " + c.getPrix() + " FCFA" + status);
            });
        }
    }
    
    private void listerComplementsActifs() {
        System.out.println("\n--- Liste des Compléments Actifs ---");
        List<Complement> complements = complementService.listerComplementsActifs();
        if (complements.isEmpty()) {
            System.out.println("Aucun complément actif.");
        } else {
            complements.forEach(c -> 
                System.out.println("ID: " + c.getId() + " | " + c.getNom() + " | " + c.getPrix() + " FCFA")
            );
        }
    }
    
    private void rechercherComplement() {
        System.out.println("\n--- Rechercher un Complément ---");
        System.out.print("Nom à rechercher : ");
        String nom = scanner.nextLine();
        List<Complement> resultats = complementService.rechercherParNom(nom);
        
        if (resultats.isEmpty()) {
            System.out.println("Aucun résultat trouvé.");
        } else {
            System.out.println("\nRésultats de la recherche :");
            resultats.forEach(c -> 
                System.out.println("ID: " + c.getId() + " | " + c.getNom() + " | " + c.getPrix() + " FCFA")
            );
        }
    }
    
    // ========== UTILITAIRES ==========
    
    private List<Burger> selectionnerBurgers(String input) {
        List<Burger> selection = new ArrayList<>();
        if (input == null || input.isBlank()) return selection;
        
        String[] ids = input.split(",");
        List<Burger> burgersActifs = burgerService.listerBurgersActifs();
        
        for (String idStr : ids) {
            try {
                int id = Integer.parseInt(idStr.trim());
                burgersActifs.stream()
                    .filter(b -> b.getId() == id)
                    .findFirst()
                    .ifPresent(selection::add);
            } catch (NumberFormatException e) {
                // Ignorer les IDs invalides
            }
        }
        return selection;
    }
    
    private List<Complement> selectionnerComplements(String input) {
        List<Complement> selection = new ArrayList<>();
        if (input == null || input.isBlank()) return selection;
        
        String[] ids = input.split(",");
        List<Complement> complementsActifs = complementService.listerComplementsActifs();
        
        for (String idStr : ids) {
            try {
                int id = Integer.parseInt(idStr.trim());
                complementsActifs.stream()
                    .filter(c -> c.getId() == id)
                    .findFirst()
                    .ifPresent(selection::add);
            } catch (NumberFormatException e) {
                // Ignorer les IDs invalides
            }
        }
        return selection;
    }
    
    private int lireEntier() {
        try {
            String input = scanner.nextLine();
            return Integer.parseInt(input);
        } catch (NumberFormatException e) {
            return -1;
        }
    }
    
    private double lireDouble() {
        try {
            String input = scanner.nextLine();
            return Double.parseDouble(input);
        } catch (NumberFormatException e) {
            return 0.0;
        }
    }
}

