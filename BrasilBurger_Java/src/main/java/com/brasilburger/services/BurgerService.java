package com.brasilburger.services;

import com.brasilburger.models.Burger;
import java.util.List;

public class BurgerService {
    private List<Burger> burgers;

    public BurgerService(List<Burger> burgers) {
        this.burgers = burgers;
    }

    public void ajouterBurger(Burger burger) { burgers.add(burger); }
    public void archiverBurger(int id) {
        burgers.stream()
               .filter(b -> b.getId() == id)
               .forEach(b -> b.setArchive(true));
    }
    public List<Burger> listerBurgers() { return burgers; }
}