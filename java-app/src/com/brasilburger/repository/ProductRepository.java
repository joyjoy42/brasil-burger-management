package com.brasilburger.repository;

import com.brasilburger.model.Product;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class ProductRepository {
    public List<Product> getAllBurgers() {
        return getProductsByType("BURGER");
    }

    public List<Product> getAllComplements() {
        return getProductsByType("COMPLEMENT");
    }

    private List<Product> getProductsByType(String type) {
        List<Product> products = new ArrayList<>();
        String sql = "SELECT * FROM products WHERE type = ?::product_type AND est_archive = FALSE";
        try (Connection conn = DatabaseUtils.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql)) {
            pstmt.setString(1, type);
            ResultSet rs = pstmt.executeQuery();
            while (rs.next()) {
                Product p = new Product();
                p.setId(rs.getInt("id"));
                p.setNom(rs.getString("nom"));
                p.setPrix(rs.getDouble("prix"));
                p.setType(rs.getString("type"));
                products.add(p);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return products;
    }

    public List<Product> getAllMenus() {
        List<Product> menus = new ArrayList<>();
        String sql = "SELECT * FROM menus WHERE est_archive = FALSE";
        try (Connection conn = DatabaseUtils.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            while (rs.next()) {
                Product p = new Product();
                p.setId(rs.getInt("id"));
                p.setNom(rs.getString("nom"));
                p.setType("MENU");
                // Menu price calculation is usually dynamic (sum of components)
                menus.add(p);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return menus;
    }
}
