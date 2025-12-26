package com.brasilburger;

import com.brasilburger.service.ResourceService;

import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        System.out.println("=========================================");
        System.out.println("   BRASIL BURGER MANAGER (JAVA CONSOLE)   ");
        System.out.println("=========================================");

        ResourceService service = new ResourceService();
        Scanner scanner = new Scanner(System.in);

        while (true) {
            System.out.println("\n### MAIN MENU ###");
            System.out.println("1. List Burgers");
            System.out.println("2. Add Burger");
            System.out.println("3. List Menus");
            System.out.println("4. Add Menu");
            System.out.println("5. List Complements");
            System.out.println("6. Add Complement");
            System.out.println("0. Exit");
            System.out.print("Choose an option: ");

            String choice = scanner.nextLine();

            switch (choice) {
                case "1":
                    service.listBurgers();
                    break;
                case "2":
                    service.addBurger();
                    break;
                case "3":
                    service.listMenus();
                    break;
                case "4":
                    service.addMenu();
                    break;
                case "5":
                    service.listComplements();
                    break;
                case "6":
                    service.addComplement();
                    break;
                case "0":
                    System.out.println("Goodbye!");
                    return;
                default:
                    System.out.println("Invalid option, please try again.");
            }
        }
    }
}
