package com.brasilburger.dao;

import com.brasilburger.database.DatabaseConnection;
import com.brasilburger.models.Complement;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

public class ComplementDAO {
    private DatabaseConnection dbConnection;
    
    public ComplementDAO() {
        this.dbConnection = DatabaseConnection.getInstance();
    }
    
    // Créer un complément
    public int create(Complement complement) throws SQLException {
        String sql = "INSERT INTO Complements (nom, prix, image, archive) VALUES (?, ?, ?, ?) RETURNING id";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setString(1, complement.getNom());
            stmt.setDouble(2, complement.getPrix());
            stmt.setString(3, complement.getImage());
            stmt.setBoolean(4, complement.isArchive());
            
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                int id = rs.getInt("id");
                complement.setId(id);
                return id;
            }
            return -1;
        }
    }
    
    // Lire un complément par ID
    public Optional<Complement> findById(int id) throws SQLException {
        String sql = "SELECT * FROM Complements WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            
            if (rs.next()) {
                return Optional.of(mapResultSetToComplement(rs));
            }
            return Optional.empty();
        }
    }
    
    // Lire tous les compléments
    public List<Complement> findAll() throws SQLException {
        String sql = "SELECT * FROM Complements ORDER BY id";
        List<Complement> complements = new ArrayList<>();
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            while (rs.next()) {
                complements.add(mapResultSetToComplement(rs));
            }
        }
        return complements;
    }
    
    // Lire uniquement les compléments actifs
    public List<Complement> findAllActive() throws SQLException {
        String sql = "SELECT * FROM Complements WHERE archive = false ORDER BY id";
        List<Complement> complements = new ArrayList<>();
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            while (rs.next()) {
                complements.add(mapResultSetToComplement(rs));
            }
        }
        return complements;
    }
    
    // Rechercher par nom
    public List<Complement> searchByName(String nom) throws SQLException {
        String sql = "SELECT * FROM Complements WHERE LOWER(nom) LIKE LOWER(?) ORDER BY id";
        List<Complement> complements = new ArrayList<>();
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setString(1, "%" + nom + "%");
            ResultSet rs = stmt.executeQuery();
            
            while (rs.next()) {
                complements.add(mapResultSetToComplement(rs));
            }
        }
        return complements;
    }
    
    // Mettre à jour un complément
    public boolean update(Complement complement) throws SQLException {
        String sql = "UPDATE Complements SET nom = ?, prix = ?, image = ?, archive = ? WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setString(1, complement.getNom());
            stmt.setDouble(2, complement.getPrix());
            stmt.setString(3, complement.getImage());
            stmt.setBoolean(4, complement.isArchive());
            stmt.setInt(5, complement.getId());
            
            return stmt.executeUpdate() > 0;
        }
    }
    
    // Archiver un complément
    public boolean archive(int id) throws SQLException {
        String sql = "UPDATE Complements SET archive = true WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            return stmt.executeUpdate() > 0;
        }
    }
    
    // Désarchiver un complément
    public boolean unarchive(int id) throws SQLException {
        String sql = "UPDATE Complements SET archive = false WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            return stmt.executeUpdate() > 0;
        }
    }
    
    // Obtenir le prochain ID disponible
    public int getNextId() throws SQLException {
        String sql = "SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM Complements";
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            if (rs.next()) {
                return rs.getInt("next_id");
            }
            return 1;
        }
    }
    
    // Mapper ResultSet vers Complement
    private Complement mapResultSetToComplement(ResultSet rs) throws SQLException {
        Complement complement = new Complement();
        complement.setId(rs.getInt("id"));
        complement.setNom(rs.getString("nom"));
        complement.setPrix(rs.getDouble("prix"));
        complement.setImage(rs.getString("image"));
        complement.setArchive(rs.getBoolean("archive"));
        return complement;
    }
}

