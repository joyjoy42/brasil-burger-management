package com.brasilburger.utils;

import com.brasilburger.models.Burger;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.core.type.TypeReference;
import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.List;

public class DataLoader {
    public static List<Burger> loadBurgers(String filePath) {
        ObjectMapper mapper = new ObjectMapper();
        try {
            Path path;
            if (filePath == null || filePath.isBlank()) {
                path = Paths.get("resources", "burgers.json");
            } else {
                path = Paths.get(filePath);
            }

            if (!Files.exists(path)) {
                // If user provided a path and it doesn't exist, try fallback to project resources
                Path fallback = Paths.get("resources", "burgers.json");
                if (Files.exists(fallback)) path = fallback;
                else return new ArrayList<>();
            }

            byte[] bytes = Files.readAllBytes(path);
            if (bytes.length == 0) return new ArrayList<>();
            return mapper.readValue(bytes, new TypeReference<List<Burger>>() {});
        } catch (IOException e) {
            System.err.println("DataLoader.loadBurgers error: " + e.getMessage());
            return new ArrayList<>();
        }
    }
}