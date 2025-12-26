package com.brasilburger.dao;

import com.brasilburger.config.Database;
import com.brasilburger.model.Burger;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class BurgerDAO {
    private Connection connection;

    public BurgerDAO() {
        this.connection = Database.getInstance().getConnection();
    }

    public void addBurger(Burger burger) {
        String sql = "INSERT INTO \"Burgers\" (\"Nom\", \"Prix\", \"Image\", \"Description\", \"IsArchived\") VALUES (?, ?, ?, ?, ?)";
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            pstmt.setString(1, burger.getNom());
            pstmt.setBigDecimal(2, burger.getPrix());
            pstmt.setString(3, burger.getImage());
            pstmt.setString(4, burger.getDescription());
            pstmt.setBoolean(5, burger.isArchived());
            pstmt.executeUpdate();
            System.out.println("✅ Burger added successfully!");
        } catch (SQLException e) {
            System.err.println("Error adding burger: " + e.getMessage());
        }
    }

    public List<Burger> getAllBurgers() {
        List<Burger> burgers = new ArrayList<>();
        String sql = "SELECT * FROM \"Burgers\" WHERE \"IsArchived\" = false";
        try (Statement stmt = connection.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Burger b = new Burger();
                b.setId(rs.getInt("Id"));
                b.setNom(rs.getString("Nom"));
                b.setPrix(rs.getBigDecimal("Prix"));
                b.setImage(rs.getString("Image"));
                b.setDescription(rs.getString("Description"));
                b.setArchived(rs.getBoolean("IsArchived"));
                burgers.add(b);
            }
        } catch (SQLException e) {
            System.err.println("Error listing burgers: " + e.getMessage());
        }
        return burgers;
    }
}
