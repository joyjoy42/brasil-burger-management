package com.brasilburger.config;

import io.github.cdimascio.dotenv.Dotenv;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class Database {
    private static Database instance;
    private Connection connection;
    private Dotenv dotenv;

    private Database() {
        try {
            // Try to load .env, but don't fail if missing (use defaults or system envs)
            dotenv = Dotenv.configure().ignoreIfMissing().load();
            
            // Default to local postgres if not specified
            String dbUrl = dotenv.get("DB_URL", "jdbc:postgresql://localhost:5432/BrasilBurger");
            String dbUser = dotenv.get("DB_USER", "postgres");
            String dbPass = dotenv.get("DB_PASS", "password"); // Change this default in production

            this.connection = DriverManager.getConnection(dbUrl, dbUser, dbPass);
            System.out.println("✅ Connected to Database: " + dbUrl);
        } catch (SQLException e) {
            System.err.println("❌ Database Connection Failed: " + e.getMessage());
            e.printStackTrace();
        }
    }

    public static Database getInstance() {
        if (instance == null) {
            instance = new Database();
        } else {
            try {
                if (instance.getConnection().isClosed()) {
                    instance = new Database();
                }
            } catch (SQLException e) {
                instance = new Database();
            }
        }
        return instance;
    }

    public Connection getConnection() {
        return connection;
    }
}
