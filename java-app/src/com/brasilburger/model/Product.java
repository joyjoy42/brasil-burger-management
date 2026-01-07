package com.brasilburger.model;

public class Product {
    private int id;
    private String nom;
    private Double prix;
    private String type; // BURGER, COMPLEMENT
    private String image;
    private boolean estArchive;

    public Product() {}

    public Product(int id, String nom, Double prix, String type) {
        this.id = id;
        this.nom = nom;
        this.prix = prix;
        this.type = type;
    }

    // Getters and Setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }
    public String getNom() { return nom; }
    public void setNom(String nom) { this.nom = nom; }
    public Double getPrix() { return prix; }
    public void setPrix(Double prix) { this.prix = prix; }
    public String getType() { return type; }
    public void setType(String type) { this.type = type; }
    public String getImage() { return image; }
    public void setImage(String image) { this.image = image; }
    public boolean isEstArchive() { return estArchive; }
    public void setEstArchive(boolean estArchive) { this.estArchive = estArchive; }
}
