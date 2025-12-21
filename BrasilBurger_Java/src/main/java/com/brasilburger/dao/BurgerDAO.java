package com.brasilburger.dao;

import com.brasilburger.database.DatabaseConnection;
import com.brasilburger.models.Burger;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

public class BurgerDAO {
    private DatabaseConnection dbConnection;
    
    public BurgerDAO() {
        this.dbConnection = DatabaseConnection.getInstance();
    }
    
    // Créer un burger
    public int create(Burger burger) throws SQLException {
        String sql = "INSERT INTO Burgers (nom, prix, image, archive) VALUES (?, ?, ?, ?) RETURNING id";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setString(1, burger.getNom());
            stmt.setDouble(2, burger.getPrix());
            stmt.setString(3, burger.getImage());
            stmt.setBoolean(4, burger.isArchive());
            
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                int id = rs.getInt("id");
                burger.setId(id);
                return id;
            }
            return -1;
        }
    }
    
    // Lire un burger par ID
    public Optional<Burger> findById(int id) throws SQLException {
        String sql = "SELECT * FROM Burgers WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            
            if (rs.next()) {
                return Optional.of(mapResultSetToBurger(rs));
            }
            return Optional.empty();
        }
    }
    
    // Lire tous les burgers
    public List<Burger> findAll() throws SQLException {
        String sql = "SELECT * FROM Burgers ORDER BY id";
        List<Burger> burgers = new ArrayList<>();
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            while (rs.next()) {
                burgers.add(mapResultSetToBurger(rs));
            }
        }
        return burgers;
    }
    
    // Lire uniquement les burgers actifs
    public List<Burger> findAllActive() throws SQLException {
        String sql = "SELECT * FROM Burgers WHERE archive = false ORDER BY id";
        List<Burger> burgers = new ArrayList<>();
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            while (rs.next()) {
                burgers.add(mapResultSetToBurger(rs));
            }
        }
        return burgers;
    }
    
    // Rechercher par nom
    public List<Burger> searchByName(String nom) throws SQLException {
        String sql = "SELECT * FROM Burgers WHERE LOWER(nom) LIKE LOWER(?) ORDER BY id";
        List<Burger> burgers = new ArrayList<>();
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setString(1, "%" + nom + "%");
            ResultSet rs = stmt.executeQuery();
            
            while (rs.next()) {
                burgers.add(mapResultSetToBurger(rs));
            }
        }
        return burgers;
    }
    
    // Mettre à jour un burger
    public boolean update(Burger burger) throws SQLException {
        String sql = "UPDATE Burgers SET nom = ?, prix = ?, image = ?, archive = ? WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setString(1, burger.getNom());
            stmt.setDouble(2, burger.getPrix());
            stmt.setString(3, burger.getImage());
            stmt.setBoolean(4, burger.isArchive());
            stmt.setInt(5, burger.getId());
            
            return stmt.executeUpdate() > 0;
        }
    }
    
    // Archiver un burger
    public boolean archive(int id) throws SQLException {
        String sql = "UPDATE Burgers SET archive = true WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            return stmt.executeUpdate() > 0;
        }
    }
    
    // Désarchiver un burger
    public boolean unarchive(int id) throws SQLException {
        String sql = "UPDATE Burgers SET archive = false WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            return stmt.executeUpdate() > 0;
        }
    }
    
    // Obtenir le prochain ID disponible
    public int getNextId() throws SQLException {
        String sql = "SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM Burgers";
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            if (rs.next()) {
                return rs.getInt("next_id");
            }
            return 1;
        }
    }
    
    // Mapper ResultSet vers Burger
    private Burger mapResultSetToBurger(ResultSet rs) throws SQLException {
        Burger burger = new Burger();
        burger.setId(rs.getInt("id"));
        burger.setNom(rs.getString("nom"));
        burger.setPrix(rs.getDouble("prix"));
        burger.setImage(rs.getString("image"));
        burger.setArchive(rs.getBoolean("archive"));
        return burger;
    }
}

