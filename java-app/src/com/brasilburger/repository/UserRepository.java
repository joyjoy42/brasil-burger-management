package com.brasilburger.repository;

import com.brasilburger.model.User;
import com.brasilburger.model.UserRole;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;

public class UserRepository {
    public boolean register(User user) {
        String sql = "INSERT INTO users (login, password, role, nom, prenom, telephone, adresse) VALUES (?, ?, ?::user_role, ?, ?, ?, ?)";
        try (Connection conn = DatabaseUtils.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql)) {
            pstmt.setString(1, user.getLogin());
            pstmt.setString(2, user.getPassword());
            pstmt.setString(3, user.getRole().name());
            pstmt.setString(4, user.getNom());
            pstmt.setString(5, user.getPrenom());
            pstmt.setString(6, user.getTelephone());
            pstmt.setString(7, user.getAdresse());
            pstmt.executeUpdate();
            return true;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public User login(String login, String password) {
        String sql = "SELECT * FROM users WHERE login = ? AND password = ?";
        try (Connection conn = DatabaseUtils.getConnection();
             PreparedStatement pstmt = conn.prepareStatement(sql)) {
            pstmt.setString(1, login);
            pstmt.setString(2, password);
            ResultSet rs = pstmt.executeQuery();
            if (rs.next()) {
                User user = new User();
                user.setId(rs.getInt("id"));
                user.setLogin(rs.getString("login"));
                user.setRole(UserRole.valueOf(rs.getString("role")));
                user.setNom(rs.getString("nom"));
                user.setPrenom(rs.getString("prenom"));
                return user;
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }
}
