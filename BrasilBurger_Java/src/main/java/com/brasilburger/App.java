package com.brasilburger;

import com.brasilburger.models.Burger;
import com.brasilburger.services.BurgerService;
import com.brasilburger.utils.DataLoader;
import java.util.List;

public class App {
    public static void main(String[] args) {
        List<Burger> burgers = DataLoader.loadBurgers("resources/burgers.json");
        BurgerService burgerService = new BurgerService(burgers);

        // If no burgers loaded from file, add a sample burger
        if (burgers.isEmpty()) {
            Burger b1 = new Burger(1, "Cheese Burger", 1500, "cheese.png", false);
            burgerService.ajouterBurger(b1);
        }

        burgerService.listerBurgers().forEach(System.out::println);
    }
}