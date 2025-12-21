package com.brasilburger.utils;

import com.brasilburger.models.Burger;
import com.brasilburger.models.Menu;
import com.brasilburger.models.Complement;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.core.type.TypeReference;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.List;

public class DataLoader {
    private static final ObjectMapper mapper = new ObjectMapper();
    
    // ========== CHARGEMENT ==========
    
    public static List<Burger> loadBurgers(String filePath) {
        try {
            Path path = getPath(filePath, "burgers.json");
            if (path == null) return new ArrayList<>();

            byte[] bytes = Files.readAllBytes(path);
            if (bytes.length == 0) return new ArrayList<>();
            return mapper.readValue(bytes, new TypeReference<List<Burger>>() {});
        } catch (IOException e) {
            System.err.println("DataLoader.loadBurgers error: " + e.getMessage());
            return new ArrayList<>();
        }
    }
    
    public static List<Menu> loadMenus(String filePath) {
        try {
            Path path = getPath(filePath, "menus.json");
            if (path == null) return new ArrayList<>();

            byte[] bytes = Files.readAllBytes(path);
            if (bytes.length == 0) return new ArrayList<>();
            return mapper.readValue(bytes, new TypeReference<List<Menu>>() {});
        } catch (IOException e) {
            System.err.println("DataLoader.loadMenus error: " + e.getMessage());
            return new ArrayList<>();
        }
    }
    
    public static List<Complement> loadComplements(String filePath) {
        try {
            Path path = getPath(filePath, "complements.json");
            if (path == null) return new ArrayList<>();

            byte[] bytes = Files.readAllBytes(path);
            if (bytes.length == 0) return new ArrayList<>();
            return mapper.readValue(bytes, new TypeReference<List<Complement>>() {});
        } catch (IOException e) {
            System.err.println("DataLoader.loadComplements error: " + e.getMessage());
            return new ArrayList<>();
        }
    }
    
    // ========== SAUVEGARDE ==========
    
    public static boolean saveBurgers(List<Burger> burgers, String filePath) {
        try {
            Path path = getPath(filePath, "burgers.json");
            if (path == null) {
                path = Paths.get("resources", "burgers.json");
                Files.createDirectories(path.getParent());
            }
            
            mapper.writerWithDefaultPrettyPrinter().writeValue(path.toFile(), burgers);
            return true;
        } catch (IOException e) {
            System.err.println("DataLoader.saveBurgers error: " + e.getMessage());
            return false;
        }
    }
    
    public static boolean saveMenus(List<Menu> menus, String filePath) {
        try {
            Path path = getPath(filePath, "menus.json");
            if (path == null) {
                path = Paths.get("resources", "menus.json");
                Files.createDirectories(path.getParent());
            }
            
            mapper.writerWithDefaultPrettyPrinter().writeValue(path.toFile(), menus);
            return true;
        } catch (IOException e) {
            System.err.println("DataLoader.saveMenus error: " + e.getMessage());
            return false;
        }
    }
    
    public static boolean saveComplements(List<Complement> complements, String filePath) {
        try {
            Path path = getPath(filePath, "complements.json");
            if (path == null) {
                path = Paths.get("resources", "complements.json");
                Files.createDirectories(path.getParent());
            }
            
            mapper.writerWithDefaultPrettyPrinter().writeValue(path.toFile(), complements);
            return true;
        } catch (IOException e) {
            System.err.println("DataLoader.saveComplements error: " + e.getMessage());
            return false;
        }
    }
    
    // ========== UTILITAIRES ==========
    
    private static Path getPath(String filePath, String defaultFile) {
        Path path;
        if (filePath == null || filePath.isBlank()) {
            path = Paths.get("resources", defaultFile);
        } else {
            path = Paths.get(filePath);
        }

        if (!Files.exists(path)) {
            Path fallback = Paths.get("resources", defaultFile);
            if (Files.exists(fallback)) {
                path = fallback;
            } else {
                return null;
            }
        }
        
        return path;
    }
}