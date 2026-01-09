package com.brasilburger.repository;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

public class DatabaseUtils {
    private static final String URL = "jdbc:postgresql://ep-fancy-mode-a4bg18kq-pooler.us-east-1.aws.neon.tech/neondb?sslmode=require";
    private static final String USER = "neondb_owner";
    private static final String PASSWORD = "npg_fgvbm4Vze5oD";
    public static final String CLOUDINARY_URL = "cloudinary://166294258315442:9bpSi55tkiP5IZnwNpHrMuw-Qsc@dbkji1d1j";

    static {
        try {
            Class.forName("org.postgresql.Driver");
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        }
    }

    public static Connection getConnection() throws SQLException {
        return DriverManager.getConnection(URL, USER, PASSWORD);
    }
}
