package com.brasilburger.dao;

import com.brasilburger.config.Database;
import com.brasilburger.model.Menu;

import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class MenuDAO {
    private Connection connection;

    public MenuDAO() {
        this.connection = Database.getInstance().getConnection();
    }

    public void addMenu(Menu menu) {
        String sql = "INSERT INTO \"Menus\" (\"Nom\", \"Prix\", \"Image\", \"Description\", \"IsArchived\") VALUES (?, ?, ?, ?, ?)";
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            pstmt.setString(1, menu.getNom());
            pstmt.setBigDecimal(2, menu.getPrix());
            pstmt.setString(3, menu.getImage());
            pstmt.setString(4, menu.getDescription());
            pstmt.setBoolean(5, menu.isArchived());
            pstmt.executeUpdate();
            System.out.println("✅ Menu added successfully!");
        } catch (SQLException e) {
            System.err.println("Error adding menu: " + e.getMessage());
        }
    }

    public List<Menu> getAllMenus() {
        List<Menu> menus = new ArrayList<>();
        String sql = "SELECT * FROM \"Menus\" WHERE \"IsArchived\" = false";
        try (Statement stmt = connection.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Menu m = new Menu();
                m.setId(rs.getInt("Id"));
                m.setNom(rs.getString("Nom"));
                m.setPrix(rs.getBigDecimal("Prix"));
                m.setImage(rs.getString("Image"));
                m.setDescription(rs.getString("Description"));
                m.setArchived(rs.getBoolean("IsArchived"));
                menus.add(m);
            }
        } catch (SQLException e) {
            System.err.println("Error listing menus: " + e.getMessage());
        }
        return menus;
    }
}
