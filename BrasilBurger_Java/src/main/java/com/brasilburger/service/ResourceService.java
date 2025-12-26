package com.brasilburger.service;

import com.brasilburger.dao.BurgerDAO;
import com.brasilburger.dao.ComplementDAO;
import com.brasilburger.dao.MenuDAO;
import com.brasilburger.model.Burger;
import com.brasilburger.model.Complement;
import com.brasilburger.model.Menu;

import java.math.BigDecimal;
import java.util.List;
import java.util.Scanner;

public class ResourceService {
    private BurgerDAO burgerDAO = new BurgerDAO();
    private MenuDAO menuDAO = new MenuDAO();
    private ComplementDAO complementDAO = new ComplementDAO();
    private Scanner scanner = new Scanner(System.in);

    // --- BURGERS ---
    public void listBurgers() {
        List<Burger> burgers = burgerDAO.getAllBurgers();
        if (burgers.isEmpty()) {
            System.out.println("No burgers found.");
        } else {
            System.out.println("\n--- LIST OF BURGERS ---");
            for (Burger b : burgers) {
                System.out.printf("[%d] %s - %s FCFA (%s)\n", b.getId(), b.getNom(), b.getPrix(), b.getDescription());
            }
        }
    }

    public void addBurger() {
        System.out.println("\n--- NEW BURGER ---");
        System.out.print("Name: ");
        String nom = scanner.nextLine();
        System.out.print("Price: ");
        BigDecimal prix = new BigDecimal(scanner.nextLine());
        System.out.print("Description: ");
        String description = scanner.nextLine();
        System.out.print("Image URL: ");
        String image = scanner.nextLine();

        Burger b = new Burger(0, nom, prix, image, description, false);
        burgerDAO.addBurger(b);
    }

    // --- MENUS ---
    public void listMenus() {
        List<Menu> menus = menuDAO.getAllMenus();
        if (menus.isEmpty()) {
            System.out.println("No menus found.");
        } else {
            System.out.println("\n--- LIST OF MENUS ---");
            for (Menu m : menus) {
                System.out.printf("[%d] %s - %s FCFA (%s)\n", m.getId(), m.getNom(), m.getPrix(), m.getDescription());
            }
        }
    }

    public void addMenu() {
        System.out.println("\n--- NEW MENU ---");
        System.out.print("Name: ");
        String nom = scanner.nextLine();
        System.out.print("Price: ");
        BigDecimal prix = new BigDecimal(scanner.nextLine());
        System.out.print("Description: ");
        String description = scanner.nextLine();
        System.out.print("Image URL: ");
        String image = scanner.nextLine();

        Menu m = new Menu(0, nom, prix, image, description, false, null, null);
        menuDAO.addMenu(m);
    }

    // --- COMPLEMENTS ---
    public void listComplements() {
        List<Complement> complements = complementDAO.getAllComplements();
        if (complements.isEmpty()) {
            System.out.println("No complements found.");
        } else {
            System.out.println("\n--- LIST OF COMPLEMENTS ---");
            for (Complement c : complements) {
                System.out.printf("[%d] %s (%s) - %s FCFA\n", c.getId(), c.getNom(), c.getType(), c.getPrix());
            }
        }
    }

    public void addComplement() {
        System.out.println("\n--- NEW COMPLEMENT ---");
        System.out.print("Name: ");
        String nom = scanner.nextLine();
        System.out.print("Type (frite/boisson): ");
        String type = scanner.nextLine();
        System.out.print("Price: ");
        BigDecimal prix = new BigDecimal(scanner.nextLine());
        System.out.print("Image URL: ");
        String image = scanner.nextLine();

        Complement c = new Complement(0, nom, prix, image, type, false);
        complementDAO.addComplement(c);
    }
}
