package com.brasilburger.services;

import com.brasilburger.dao.MenuDAO;
import com.brasilburger.models.Menu;
import com.brasilburger.models.Burger;
import com.brasilburger.models.Complement;
import java.sql.SQLException;
import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

public class MenuService {
    private MenuDAO menuDAO;

    public MenuService() {
        this.menuDAO = new MenuDAO();
    }
    
    // Constructeur pour compatibilité
    public MenuService(List<Menu> menus) {
        this();
    }

    // Ajouter un menu
    public boolean ajouterMenu(Menu menu) {
        try {
            int id = menuDAO.create(menu);
            return id > 0;
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'ajout du menu: " + e.getMessage());
            return false;
        }
    }
    
    // Modifier un menu
    public boolean modifierMenu(int id, String nom, String image, List<Burger> burgers, List<Complement> complements) {
        try {
            Optional<Menu> menuOpt = menuDAO.findById(id);
            if (menuOpt.isPresent()) {
                Menu menu = menuOpt.get();
                menu.setNom(nom);
                menu.setImage(image);
                menu.setBurgers(burgers);
                menu.setComplements(complements);
                return menuDAO.update(menu);
            }
            return false;
        } catch (SQLException e) {
            System.err.println("Erreur lors de la modification du menu: " + e.getMessage());
            return false;
        }
    }
    
    // Archiver un menu (soft delete)
    public boolean archiverMenu(int id) {
        try {
            return menuDAO.archive(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'archivage du menu: " + e.getMessage());
            return false;
        }
    }
    
    // Désarchiver un menu
    public boolean desarchiverMenu(int id) {
        try {
            return menuDAO.unarchive(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors du désarchivage du menu: " + e.getMessage());
            return false;
        }
    }
    
    // Rechercher un menu par ID
    public Optional<Menu> trouverMenu(int id) {
        try {
            return menuDAO.findById(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors de la recherche du menu: " + e.getMessage());
            return Optional.empty();
        }
    }
    
    // Rechercher un menu par nom
    public List<Menu> rechercherParNom(String nom) {
        try {
            List<Menu> tous = menuDAO.findAll();
            return tous.stream()
                .filter(m -> m.getNom().toLowerCase().contains(nom.toLowerCase()))
                .collect(Collectors.toList());
        } catch (SQLException e) {
            System.err.println("Erreur lors de la recherche: " + e.getMessage());
            return List.of();
        }
    }
    
    // Calculer le prix total d'un menu (somme des burgers + compléments)
    public double calculerPrixMenu(Menu menu) {
        double prixBurgers = menu.getBurgers() != null ? 
            menu.getBurgers().stream().mapToDouble(Burger::getPrix).sum() : 0.0;
        double prixComplements = menu.getComplements() != null ? 
            menu.getComplements().stream().mapToDouble(Complement::getPrix).sum() : 0.0;
        return prixBurgers + prixComplements;
    }
    
    // Lister tous les menus
    public List<Menu> listerMenus() {
        try {
            return menuDAO.findAll();
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des menus: " + e.getMessage());
            return List.of();
        }
    }
    
    // Lister uniquement les menus actifs (non archivés)
    public List<Menu> listerMenusActifs() {
        try {
            return menuDAO.findAllActive();
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des menus actifs: " + e.getMessage());
            return List.of();
        }
    }
    
    // Lister uniquement les menus archivés
    public List<Menu> listerMenusArchives() {
        try {
            List<Menu> tous = menuDAO.findAll();
            return tous.stream()
                .filter(Menu::isArchive)
                .collect(Collectors.toList());
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des menus archivés: " + e.getMessage());
            return List.of();
        }
    }
    
    // Obtenir le prochain ID disponible
    public int obtenirProchainId() {
        try {
            return menuDAO.getNextId();
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'obtention du prochain ID: " + e.getMessage());
            return 1;
        }
    }
}

