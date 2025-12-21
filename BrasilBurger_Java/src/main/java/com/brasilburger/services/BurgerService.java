package com.brasilburger.services;

import com.brasilburger.dao.BurgerDAO;
import com.brasilburger.models.Burger;
import java.sql.SQLException;
import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

public class BurgerService {
    private BurgerDAO burgerDAO;

    public BurgerService() {
        this.burgerDAO = new BurgerDAO();
    }
    
    // Constructeur pour compatibilité (utilise DAO)
    public BurgerService(List<Burger> burgers) {
        this();
        // Optionnel: charger depuis la liste si nécessaire
    }

    // Ajouter un burger
    public boolean ajouterBurger(Burger burger) {
        try {
            int id = burgerDAO.create(burger);
            return id > 0;
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'ajout du burger: " + e.getMessage());
            return false;
        }
    }
    
    // Modifier un burger
    public boolean modifierBurger(int id, String nom, double prix, String image) {
        try {
            Optional<Burger> burgerOpt = burgerDAO.findById(id);
            if (burgerOpt.isPresent()) {
                Burger burger = burgerOpt.get();
                burger.setNom(nom);
                burger.setPrix(prix);
                burger.setImage(image);
                return burgerDAO.update(burger);
            }
            return false;
        } catch (SQLException e) {
            System.err.println("Erreur lors de la modification du burger: " + e.getMessage());
            return false;
        }
    }
    
    // Archiver un burger (soft delete)
    public boolean archiverBurger(int id) {
        try {
            return burgerDAO.archive(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'archivage du burger: " + e.getMessage());
            return false;
        }
    }
    
    // Désarchiver un burger
    public boolean desarchiverBurger(int id) {
        try {
            return burgerDAO.unarchive(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors du désarchivage du burger: " + e.getMessage());
            return false;
        }
    }
    
    // Rechercher un burger par ID
    public Optional<Burger> trouverBurger(int id) {
        try {
            return burgerDAO.findById(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors de la recherche du burger: " + e.getMessage());
            return Optional.empty();
        }
    }
    
    // Rechercher un burger par nom
    public List<Burger> rechercherParNom(String nom) {
        try {
            return burgerDAO.searchByName(nom);
        } catch (SQLException e) {
            System.err.println("Erreur lors de la recherche: " + e.getMessage());
            return List.of();
        }
    }
    
    // Lister tous les burgers
    public List<Burger> listerBurgers() {
        try {
            return burgerDAO.findAll();
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des burgers: " + e.getMessage());
            return List.of();
        }
    }
    
    // Lister uniquement les burgers actifs (non archivés)
    public List<Burger> listerBurgersActifs() {
        try {
            return burgerDAO.findAllActive();
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des burgers actifs: " + e.getMessage());
            return List.of();
        }
    }
    
    // Lister uniquement les burgers archivés
    public List<Burger> listerBurgersArchives() {
        try {
            List<Burger> tous = burgerDAO.findAll();
            return tous.stream()
                .filter(Burger::isArchive)
                .collect(Collectors.toList());
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des burgers archivés: " + e.getMessage());
            return List.of();
        }
    }
    
    // Obtenir le prochain ID disponible
    public int obtenirProchainId() {
        try {
            return burgerDAO.getNextId();
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'obtention du prochain ID: " + e.getMessage());
            return 1;
        }
    }
}