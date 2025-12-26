package com.brasilburger.model;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.math.BigDecimal;

@Data
@NoArgsConstructor
@AllArgsConstructor
public class Complement {
    private int id;
    private String nom;
    private BigDecimal prix;
    private String image;
    private String type; // "frite" or "boisson"
    private boolean isArchived;
}
