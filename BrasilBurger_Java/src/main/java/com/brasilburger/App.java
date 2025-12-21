package com.brasilburger;

import com.brasilburger.database.DatabaseConnection;
import com.brasilburger.services.BurgerService;
import com.brasilburger.services.MenuService;
import com.brasilburger.services.ComplementService;
import com.brasilburger.ui.MenuConsole;

public class App {
    public static void main(String[] args) {
        System.out.println("╔════════════════════════════════════════════════════════╗");
        System.out.println("║     BRASIL BURGER - GESTION DES RESSOURCES            ║");
        System.out.println("║     Application Console Java                          ║");
        System.out.println("║     Base de données: PostgreSQL (Neon)                ║");
        System.out.println("╚════════════════════════════════════════════════════════╝");
        
        // Tester la connexion à la base de données
        DatabaseConnection dbConnection = DatabaseConnection.getInstance();
        System.out.println("\n🔌 Test de connexion à la base de données...");
        dbConnection.testConnection();
        
        // Initialiser les services (utilisent maintenant PostgreSQL via DAO)
        BurgerService burgerService = new BurgerService();
        MenuService menuService = new MenuService();
        ComplementService complementService = new ComplementService();
        
        // Lancer l'interface console
        MenuConsole menuConsole = new MenuConsole(burgerService, menuService, complementService);
        menuConsole.afficherMenuPrincipal();
        
        // Fermer la connexion avant de quitter
        System.out.println("\n💾 Fermeture de la connexion...");
        dbConnection.closeConnection();
        System.out.println("✅ Application fermée.");
    }
}