package com.brasilburger.dao;

import com.brasilburger.config.Database;
import com.brasilburger.model.Complement;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ComplementDAO {
    private Connection connection;

    public ComplementDAO() {
        this.connection = Database.getInstance().getConnection();
    }

    public void addComplement(Complement complement) {
        String sql = "INSERT INTO \"Complements\" (\"Nom\", \"Prix\", \"Image\", \"Type\", \"IsArchived\") VALUES (?, ?, ?, ?, ?)";
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            pstmt.setString(1, complement.getNom());
            pstmt.setBigDecimal(2, complement.getPrix());
            pstmt.setString(3, complement.getImage());
            pstmt.setString(4, complement.getType());
            pstmt.setBoolean(5, complement.isArchived());
            pstmt.executeUpdate();
            System.out.println("✅ Complement added successfully!");
        } catch (SQLException e) {
            System.err.println("Error adding complement: " + e.getMessage());
        }
    }

    public List<Complement> getAllComplements() {
        List<Complement> complements = new ArrayList<>();
        String sql = "SELECT * FROM \"Complements\" WHERE \"IsArchived\" = false";
        try (Statement stmt = connection.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Complement c = new Complement();
                c.setId(rs.getInt("Id"));
                c.setNom(rs.getString("Nom"));
                c.setPrix(rs.getBigDecimal("Prix"));
                c.setImage(rs.getString("Image"));
                c.setType(rs.getString("Type"));
                c.setArchived(rs.getBoolean("IsArchived"));
                complements.add(c);
            }
        } catch (SQLException e) {
            System.err.println("Error listing complements: " + e.getMessage());
        }
        return complements;
    }
}
