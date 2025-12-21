package com.brasilburger.database;

import java.io.InputStream;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.util.Properties;

public class DatabaseConnection {
    private static DatabaseConnection instance;
    private Connection connection;
    private String url;
    private String username;
    private String password;
    
    private DatabaseConnection() {
        loadProperties();
    }
    
    public static synchronized DatabaseConnection getInstance() {
        if (instance == null) {
            instance = new DatabaseConnection();
        }
        return instance;
    }
    
    private void loadProperties() {
        try {
            Properties props = new Properties();
            InputStream input = getClass().getClassLoader()
                .getResourceAsStream("database.properties");
            
            if (input == null) {
                // Fallback: utiliser les variables d'environnement ou valeurs par défaut
                String dbHost = System.getenv("DB_HOST");
                String dbName = System.getenv("DB_NAME");
                String dbUser = System.getenv("DB_USER");
                String dbPass = System.getenv("DB_PASSWORD");
                
                if (dbHost != null && dbName != null && dbUser != null && dbPass != null) {
                    this.url = String.format("jdbc:postgresql://%s:5432/%s?sslmode=require", dbHost, dbName);
                    this.username = dbUser;
                    this.password = dbPass;
                } else {
                    // Valeurs par défaut (à remplacer)
                    this.url = "jdbc:postgresql://YOUR_NEON_HOST:5432/neondb?sslmode=require";
                    this.username = "YOUR_USERNAME";
                    this.password = "YOUR_PASSWORD";
                    System.err.println("⚠️  ATTENTION: Utilisation des valeurs par défaut. Configurez database.properties ou les variables d'environnement.");
                }
            } else {
                props.load(input);
                String host = props.getProperty("db.host");
                String port = props.getProperty("db.port", "5432");
                String database = props.getProperty("db.database");
                String sslMode = props.getProperty("db.sslmode", "require");
                
                this.url = String.format("jdbc:postgresql://%s:%s/%s?sslmode=%s", host, port, database, sslMode);
                this.username = props.getProperty("db.username");
                this.password = props.getProperty("db.password");
                input.close();
            }
        } catch (Exception e) {
            System.err.println("Erreur lors du chargement de la configuration: " + e.getMessage());
            // Valeurs par défaut
            this.url = "jdbc:postgresql://YOUR_NEON_HOST:5432/neondb?sslmode=require";
            this.username = "YOUR_USERNAME";
            this.password = "YOUR_PASSWORD";
        }
    }
    
    public Connection getConnection() throws SQLException {
        if (connection == null || connection.isClosed()) {
            try {
                connection = DriverManager.getConnection(url, username, password);
                System.out.println("✅ Connexion à la base de données établie.");
            } catch (SQLException e) {
                System.err.println("❌ Erreur de connexion à la base de données: " + e.getMessage());
                throw e;
            }
        }
        return connection;
    }
    
    public void closeConnection() {
        try {
            if (connection != null && !connection.isClosed()) {
                connection.close();
                System.out.println("✅ Connexion fermée.");
            }
        } catch (SQLException e) {
            System.err.println("Erreur lors de la fermeture: " + e.getMessage());
        }
    }
    
    public void testConnection() {
        try {
            Connection conn = getConnection();
            if (conn != null && !conn.isClosed()) {
                System.out.println("✅ Test de connexion réussi !");
            }
        } catch (SQLException e) {
            System.err.println("❌ Test de connexion échoué: " + e.getMessage());
        }
    }
}

