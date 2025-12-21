package com.brasilburger.services;

import com.brasilburger.dao.ComplementDAO;
import com.brasilburger.models.Complement;
import java.sql.SQLException;
import java.util.List;
import java.util.Optional;
import java.util.stream.Collectors;

public class ComplementService {
    private ComplementDAO complementDAO;

    public ComplementService() {
        this.complementDAO = new ComplementDAO();
    }
    
    // Constructeur pour compatibilité
    public ComplementService(List<Complement> complements) {
        this();
    }

    // Ajouter un complément
    public boolean ajouterComplement(Complement complement) {
        try {
            int id = complementDAO.create(complement);
            return id > 0;
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'ajout du complément: " + e.getMessage());
            return false;
        }
    }
    
    // Modifier un complément
    public boolean modifierComplement(int id, String nom, double prix, String image) {
        try {
            Optional<Complement> complementOpt = complementDAO.findById(id);
            if (complementOpt.isPresent()) {
                Complement complement = complementOpt.get();
                complement.setNom(nom);
                complement.setPrix(prix);
                complement.setImage(image);
                return complementDAO.update(complement);
            }
            return false;
        } catch (SQLException e) {
            System.err.println("Erreur lors de la modification du complément: " + e.getMessage());
            return false;
        }
    }
    
    // Archiver un complément (soft delete)
    public boolean archiverComplement(int id) {
        try {
            return complementDAO.archive(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'archivage du complément: " + e.getMessage());
            return false;
        }
    }
    
    // Désarchiver un complément
    public boolean desarchiverComplement(int id) {
        try {
            return complementDAO.unarchive(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors du désarchivage du complément: " + e.getMessage());
            return false;
        }
    }
    
    // Rechercher un complément par ID
    public Optional<Complement> trouverComplement(int id) {
        try {
            return complementDAO.findById(id);
        } catch (SQLException e) {
            System.err.println("Erreur lors de la recherche du complément: " + e.getMessage());
            return Optional.empty();
        }
    }
    
    // Rechercher un complément par nom
    public List<Complement> rechercherParNom(String nom) {
        try {
            return complementDAO.searchByName(nom);
        } catch (SQLException e) {
            System.err.println("Erreur lors de la recherche: " + e.getMessage());
            return List.of();
        }
    }
    
    // Lister tous les compléments
    public List<Complement> listerComplements() {
        try {
            return complementDAO.findAll();
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des compléments: " + e.getMessage());
            return List.of();
        }
    }
    
    // Lister uniquement les compléments actifs (non archivés)
    public List<Complement> listerComplementsActifs() {
        try {
            return complementDAO.findAllActive();
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des compléments actifs: " + e.getMessage());
            return List.of();
        }
    }
    
    // Lister uniquement les compléments archivés
    public List<Complement> listerComplementsArchives() {
        try {
            List<Complement> tous = complementDAO.findAll();
            return tous.stream()
                .filter(Complement::isArchive)
                .collect(Collectors.toList());
        } catch (SQLException e) {
            System.err.println("Erreur lors du chargement des compléments archivés: " + e.getMessage());
            return List.of();
        }
    }
    
    // Obtenir le prochain ID disponible
    public int obtenirProchainId() {
        try {
            return complementDAO.getNextId();
        } catch (SQLException e) {
            System.err.println("Erreur lors de l'obtention du prochain ID: " + e.getMessage());
            return 1;
        }
    }
}

