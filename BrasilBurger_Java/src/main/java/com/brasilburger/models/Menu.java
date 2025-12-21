package com.brasilburger.models;

import java.util.List;

public class Menu {
    private int id;
    private String nom;
    private String image;
    private List<Burger> burgers;
    private List<Complement> complements;
    private boolean archive;

    public Menu() {}

    public Menu(int id, String nom, String image, List<Burger> burgers, List<Complement> complements, boolean archive) {
        this.id = id;
        this.nom = nom;
        this.image = image;
        this.burgers = burgers;
        this.complements = complements;
        this.archive = archive;
    }

    public int getId() { return id; }
    public void setId(int id) { this.id = id; }

    public String getNom() { return nom; }
    public void setNom(String nom) { this.nom = nom; }

    public String getImage() { return image; }
    public void setImage(String image) { this.image = image; }

    public List<Burger> getBurgers() { return burgers; }
    public void setBurgers(List<Burger> burgers) { this.burgers = burgers; }

    public List<Complement> getComplements() { return complements; }
    public void setComplements(List<Complement> complements) { this.complements = complements; }

    public boolean isArchive() { return archive; }
    public void setArchive(boolean archive) { this.archive = archive; }

    @Override
    public String toString() {
        return nom + " (" + (burgers != null ? burgers.size() : 0) + " burgers)";
    }
}