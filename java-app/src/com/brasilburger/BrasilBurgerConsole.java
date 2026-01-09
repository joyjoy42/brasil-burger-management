package com.brasilburger;

import com.brasilburger.model.*;
import com.brasilburger.repository.*;
import java.util.*;

public class BrasilBurgerConsole {
    private static UserRepository userRepo = new UserRepository();
    private static ProductRepository productRepo = new ProductRepository();
    private static Scanner scanner = new Scanner(System.in);
    private static User currentUser = null;

    public static void main(String[] args) {
        System.out.println("=== BIENVENUE CHEZ BRASIL BURGER ===");
        while (true) {
            if (currentUser == null) {
                showAuthMenu();
            } else {
                showMainMenu();
            }
        }
    }

    private static void showAuthMenu() {
        System.out.println("\n1. Se connecter");
        System.out.println("2. Créer un compte");
        System.out.println("3. Quitter");
        System.out.print("Choix : ");
        int choice = Integer.parseInt(scanner.nextLine());

        switch (choice) {
            case 1:
                login();
                break;
            case 2:
                register();
                break;
            case 3:
                System.exit(0);
        }
    }

    private static void login() {
        System.out.print("Login : ");
        String login = scanner.nextLine();
        System.out.print("Mot de passe : ");
        String password = scanner.nextLine();
        currentUser = userRepo.login(login, password);
        if (currentUser != null) {
            System.out.println("Connexion réussie ! Bienvenue " + currentUser.getPrenom());
        } else {
            System.out.println("Identifiants incorrects.");
        }
    }

    private static void register() {
        System.out.print("Login : ");
        String login = scanner.nextLine();
        System.out.print("Mot de passe : ");
        String password = scanner.nextLine();
        System.out.print("Nom : ");
        String nom = scanner.nextLine();
        System.out.print("Prénom : ");
        String prenom = scanner.nextLine();

        User newUser = new User();
        newUser.setLogin(login);
        newUser.setPassword(password);
        newUser.setRole(UserRole.CLIENT);
        newUser.setNom(nom);
        newUser.setPrenom(prenom);

        if (userRepo.register(newUser)) {
            System.out.println("Compte créé avec succès !");
        } else {
            System.out.println("Erreur lors de la création du compte.");
        }
    }

    private static void showMainMenu() {
        System.out.println("\n--- MENU PRINCIPAL ---");
        System.out.println("1. Voir le catalogue");
        System.out.println("2. Passer une commande");
        System.out.println("3. Suivre mes commandes");
        System.out.println("4. Se déconnecter");
        System.out.print("Choix : ");
        int choice = Integer.parseInt(scanner.nextLine());

        switch (choice) {
            case 1:
                viewCatalog();
                break;
            case 4:
                currentUser = null;
                break;
            default:
                System.out.println("Fonctionnalité en cours de développement...");
        }
    }

    private static void viewCatalog() {
        System.out.println("\n--- CATALOGUE ---");
        System.out.println("Burgers :");
        productRepo.getAllBurgers().forEach(b -> System.out.println("- " + b.getNom() + " : " + b.getPrix() + " FCFA"));
        System.out.println("\nMenus :");
        productRepo.getAllMenus().forEach(m -> System.out.println("- " + m.getNom()));
    }
}
