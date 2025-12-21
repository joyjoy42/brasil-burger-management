package com.brasilburger.dao;

import com.brasilburger.database.DatabaseConnection;
import com.brasilburger.models.Menu;
import com.brasilburger.models.Burger;
import com.brasilburger.models.Complement;
import java.sql.*;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

public class MenuDAO {
    private DatabaseConnection dbConnection;
    private BurgerDAO burgerDAO;
    private ComplementDAO complementDAO;
    
    public MenuDAO() {
        this.dbConnection = DatabaseConnection.getInstance();
        this.burgerDAO = new BurgerDAO();
        this.complementDAO = new ComplementDAO();
    }
    
    // Créer un menu
    public int create(Menu menu) throws SQLException {
        String sql = "INSERT INTO Menus (nom, image, archive) VALUES (?, ?, ?) RETURNING id";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setString(1, menu.getNom());
            stmt.setString(2, menu.getImage());
            stmt.setBoolean(3, menu.isArchive());
            
            ResultSet rs = stmt.executeQuery();
            if (rs.next()) {
                int menuId = rs.getInt("id");
                menu.setId(menuId);
                
                // Insérer les relations avec les burgers
                if (menu.getBurgers() != null && !menu.getBurgers().isEmpty()) {
                    insertMenuBurgers(conn, menuId, menu.getBurgers());
                }
                
                // Insérer les relations avec les compléments
                if (menu.getComplements() != null && !menu.getComplements().isEmpty()) {
                    insertMenuComplements(conn, menuId, menu.getComplements());
                }
                
                return menuId;
            }
            return -1;
        }
    }
    
    // Insérer les relations Menu-Burger
    private void insertMenuBurgers(Connection conn, int menuId, List<Burger> burgers) throws SQLException {
        String sql = "INSERT INTO MenuBurgers (menu_id, burger_id) VALUES (?, ?)";
        
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            for (Burger burger : burgers) {
                stmt.setInt(1, menuId);
                stmt.setInt(2, burger.getId());
                stmt.addBatch();
            }
            stmt.executeBatch();
        }
    }
    
    // Insérer les relations Menu-Complement
    private void insertMenuComplements(Connection conn, int menuId, List<Complement> complements) throws SQLException {
        String sql = "INSERT INTO MenuComplements (menu_id, complement_id) VALUES (?, ?)";
        
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            for (Complement complement : complements) {
                stmt.setInt(1, menuId);
                stmt.setInt(2, complement.getId());
                stmt.addBatch();
            }
            stmt.executeBatch();
        }
    }
    
    // Lire un menu par ID
    public Optional<Menu> findById(int id) throws SQLException {
        String sql = "SELECT * FROM Menus WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            ResultSet rs = stmt.executeQuery();
            
            if (rs.next()) {
                Menu menu = mapResultSetToMenu(rs);
                
                // Charger les burgers du menu
                menu.setBurgers(getBurgersForMenu(conn, id));
                
                // Charger les compléments du menu
                menu.setComplements(getComplementsForMenu(conn, id));
                
                return Optional.of(menu);
            }
            return Optional.empty();
        }
    }
    
    // Obtenir les burgers d'un menu
    private List<Burger> getBurgersForMenu(Connection conn, int menuId) throws SQLException {
        String sql = "SELECT b.* FROM Burgers b " +
                     "INNER JOIN MenuBurgers mb ON b.id = mb.burger_id " +
                     "WHERE mb.menu_id = ?";
        List<Burger> burgers = new ArrayList<>();
        
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, menuId);
            ResultSet rs = stmt.executeQuery();
            
            while (rs.next()) {
                Burger burger = new Burger();
                burger.setId(rs.getInt("id"));
                burger.setNom(rs.getString("nom"));
                burger.setPrix(rs.getDouble("prix"));
                burger.setImage(rs.getString("image"));
                burger.setArchive(rs.getBoolean("archive"));
                burgers.add(burger);
            }
        }
        return burgers;
    }
    
    // Obtenir les compléments d'un menu
    private List<Complement> getComplementsForMenu(Connection conn, int menuId) throws SQLException {
        String sql = "SELECT c.* FROM Complements c " +
                     "INNER JOIN MenuComplements mc ON c.id = mc.complement_id " +
                     "WHERE mc.menu_id = ?";
        List<Complement> complements = new ArrayList<>();
        
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, menuId);
            ResultSet rs = stmt.executeQuery();
            
            while (rs.next()) {
                Complement complement = new Complement();
                complement.setId(rs.getInt("id"));
                complement.setNom(rs.getString("nom"));
                complement.setPrix(rs.getDouble("prix"));
                complement.setImage(rs.getString("image"));
                complement.setArchive(rs.getBoolean("archive"));
                complements.add(complement);
            }
        }
        return complements;
    }
    
    // Lire tous les menus
    public List<Menu> findAll() throws SQLException {
        String sql = "SELECT * FROM Menus ORDER BY id";
        List<Menu> menus = new ArrayList<>();
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            while (rs.next()) {
                Menu menu = mapResultSetToMenu(rs);
                menu.setBurgers(getBurgersForMenu(conn, menu.getId()));
                menu.setComplements(getComplementsForMenu(conn, menu.getId()));
                menus.add(menu);
            }
        }
        return menus;
    }
    
    // Lire uniquement les menus actifs
    public List<Menu> findAllActive() throws SQLException {
        String sql = "SELECT * FROM Menus WHERE archive = false ORDER BY id";
        List<Menu> menus = new ArrayList<>();
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            while (rs.next()) {
                Menu menu = mapResultSetToMenu(rs);
                menu.setBurgers(getBurgersForMenu(conn, menu.getId()));
                menu.setComplements(getComplementsForMenu(conn, menu.getId()));
                menus.add(menu);
            }
        }
        return menus;
    }
    
    // Mettre à jour un menu
    public boolean update(Menu menu) throws SQLException {
        String sql = "UPDATE Menus SET nom = ?, image = ?, archive = ? WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection()) {
            conn.setAutoCommit(false);
            
            try {
                // Mettre à jour le menu
                try (PreparedStatement stmt = conn.prepareStatement(sql)) {
                    stmt.setString(1, menu.getNom());
                    stmt.setString(2, menu.getImage());
                    stmt.setBoolean(3, menu.isArchive());
                    stmt.setInt(4, menu.getId());
                    stmt.executeUpdate();
                }
                
                // Supprimer les anciennes relations
                deleteMenuBurgers(conn, menu.getId());
                deleteMenuComplements(conn, menu.getId());
                
                // Insérer les nouvelles relations
                if (menu.getBurgers() != null && !menu.getBurgers().isEmpty()) {
                    insertMenuBurgers(conn, menu.getId(), menu.getBurgers());
                }
                if (menu.getComplements() != null && !menu.getComplements().isEmpty()) {
                    insertMenuComplements(conn, menu.getId(), menu.getComplements());
                }
                
                conn.commit();
                return true;
            } catch (SQLException e) {
                conn.rollback();
                throw e;
            } finally {
                conn.setAutoCommit(true);
            }
        }
    }
    
    // Supprimer les relations Menu-Burger
    private void deleteMenuBurgers(Connection conn, int menuId) throws SQLException {
        String sql = "DELETE FROM MenuBurgers WHERE menu_id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, menuId);
            stmt.executeUpdate();
        }
    }
    
    // Supprimer les relations Menu-Complement
    private void deleteMenuComplements(Connection conn, int menuId) throws SQLException {
        String sql = "DELETE FROM MenuComplements WHERE menu_id = ?";
        try (PreparedStatement stmt = conn.prepareStatement(sql)) {
            stmt.setInt(1, menuId);
            stmt.executeUpdate();
        }
    }
    
    // Archiver un menu
    public boolean archive(int id) throws SQLException {
        String sql = "UPDATE Menus SET archive = true WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            return stmt.executeUpdate() > 0;
        }
    }
    
    // Désarchiver un menu
    public boolean unarchive(int id) throws SQLException {
        String sql = "UPDATE Menus SET archive = false WHERE id = ?";
        
        try (Connection conn = dbConnection.getConnection();
             PreparedStatement stmt = conn.prepareStatement(sql)) {
            
            stmt.setInt(1, id);
            return stmt.executeUpdate() > 0;
        }
    }
    
    // Obtenir le prochain ID disponible
    public int getNextId() throws SQLException {
        String sql = "SELECT COALESCE(MAX(id), 0) + 1 AS next_id FROM Menus";
        
        try (Connection conn = dbConnection.getConnection();
             Statement stmt = conn.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            if (rs.next()) {
                return rs.getInt("next_id");
            }
            return 1;
        }
    }
    
    // Mapper ResultSet vers Menu
    private Menu mapResultSetToMenu(ResultSet rs) throws SQLException {
        Menu menu = new Menu();
        menu.setId(rs.getInt("id"));
        menu.setNom(rs.getString("nom"));
        menu.setImage(rs.getString("image"));
        menu.setArchive(rs.getBoolean("archive"));
        return menu;
    }
}

