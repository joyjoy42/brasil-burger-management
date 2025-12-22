-- ============================================
-- Script SQL de Création de la Base de Données
-- Brasil Burger Management System
-- PostgreSQL (Neon)
-- ============================================

-- Suppression des tables si elles existent (pour réinitialisation)
DROP TABLE IF EXISTS MenuComplements CASCADE;
DROP TABLE IF EXISTS MenuBurgers CASCADE;
DROP TABLE IF EXISTS LigneCommandes CASCADE;
DROP TABLE IF EXISTS Paiements CASCADE;
DROP TABLE IF EXISTS Commandes CASCADE;
DROP TABLE IF EXISTS Livreurs CASCADE;
DROP TABLE IF EXISTS Zones CASCADE;
DROP TABLE IF EXISTS Complements CASCADE;
DROP TABLE IF EXISTS Menus CASCADE;
DROP TABLE IF EXISTS Burgers CASCADE;
DROP TABLE IF EXISTS Clients CASCADE;

-- ============================================
-- Table: Clients
-- ============================================
CREATE TABLE Clients (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: Burgers
-- ============================================
CREATE TABLE Burgers (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL CHECK (prix >= 0),
    image VARCHAR(500),
    archive BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: Menus
-- ============================================
CREATE TABLE Menus (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    image VARCHAR(500),
    archive BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: Complements
-- ============================================
CREATE TABLE Complements (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL CHECK (prix >= 0),
    image VARCHAR(500),
    archive BOOLEAN DEFAULT FALSE,
    date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: Zones (pour les livraisons)
-- ============================================
CREATE TABLE Zones (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL UNIQUE,
    prix DECIMAL(10, 2) NOT NULL CHECK (prix >= 0),
    description TEXT
);

-- ============================================
-- Table: Livreurs
-- ============================================
CREATE TABLE Livreurs (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    telephone VARCHAR(20) NOT NULL UNIQUE,
    disponible BOOLEAN DEFAULT TRUE
);

-- ============================================
-- Table: Commandes
-- ============================================
CREATE TABLE Commandes (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL REFERENCES Clients(id) ON DELETE CASCADE,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    etat VARCHAR(50) NOT NULL DEFAULT 'En attente' CHECK (etat IN ('En attente', 'Validée', 'En préparation', 'Terminée', 'Annulée', 'En livraison', 'Livrée')),
    type_livraison VARCHAR(50) NOT NULL CHECK (type_livraison IN ('Sur place', 'À emporter', 'Livraison')),
    zone_id INTEGER REFERENCES Zones(id),
    livreur_id INTEGER REFERENCES Livreurs(id),
    total DECIMAL(10, 2) NOT NULL CHECK (total >= 0),
    adresse_livraison TEXT,
    notes TEXT
);

-- ============================================
-- Table: LigneCommandes (détails des commandes)
-- ============================================
CREATE TABLE LigneCommandes (
    id SERIAL PRIMARY KEY,
    commande_id INTEGER NOT NULL REFERENCES Commandes(id) ON DELETE CASCADE,
    produit_type VARCHAR(50) NOT NULL CHECK (produit_type IN ('Burger', 'Menu')),
    produit_id INTEGER NOT NULL,
    quantite INTEGER NOT NULL CHECK (quantite > 0),
    prix DECIMAL(10, 2) NOT NULL CHECK (prix >= 0),
    complement_ids INTEGER[] DEFAULT ARRAY[]::INTEGER[]
);

-- ============================================
-- Table: Paiements
-- ============================================
CREATE TABLE Paiements (
    id SERIAL PRIMARY KEY,
    commande_id INTEGER NOT NULL UNIQUE REFERENCES Commandes(id) ON DELETE CASCADE,
    date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    montant DECIMAL(10, 2) NOT NULL CHECK (montant >= 0),
    methode VARCHAR(50) NOT NULL CHECK (methode IN ('Wave', 'OM', 'Espèces', 'Carte')),
    reference VARCHAR(255),
    statut VARCHAR(50) DEFAULT 'Validé' CHECK (statut IN ('Validé', 'En attente', 'Échoué'))
);

-- ============================================
-- Tables de Jointure: MenuBurgers
-- ============================================
CREATE TABLE MenuBurgers (
    menu_id INTEGER NOT NULL REFERENCES Menus(id) ON DELETE CASCADE,
    burger_id INTEGER NOT NULL REFERENCES Burgers(id) ON DELETE CASCADE,
    PRIMARY KEY (menu_id, burger_id)
);

-- ============================================
-- Tables de Jointure: MenuComplements
-- ============================================
CREATE TABLE MenuComplements (
    menu_id INTEGER NOT NULL REFERENCES Menus(id) ON DELETE CASCADE,
    complement_id INTEGER NOT NULL REFERENCES Complements(id) ON DELETE CASCADE,
    PRIMARY KEY (menu_id, complement_id)
);

-- ============================================
-- Index pour améliorer les performances
-- ============================================
CREATE INDEX idx_commandes_client ON Commandes(client_id);
CREATE INDEX idx_commandes_date ON Commandes(date);
CREATE INDEX idx_commandes_etat ON Commandes(etat);
CREATE INDEX idx_ligne_commandes_commande ON LigneCommandes(commande_id);
CREATE INDEX idx_paiements_commande ON Paiements(commande_id);
CREATE INDEX idx_burgers_archive ON Burgers(archive);
CREATE INDEX idx_menus_archive ON Menus(archive);
CREATE INDEX idx_complements_archive ON Complements(archive);

-- ============================================
-- Données de Test (optionnel)
-- ============================================

-- Insertion d'une zone de test
INSERT INTO Zones (nom, prix, description) VALUES
('Zone Centre-Ville', 2000, 'Centre-ville et quartiers adjacents'),
('Zone Périphérie', 3000, 'Quartiers périphériques'),
('Zone Lointaine', 5000, 'Zones éloignées du centre');

-- Insertion d'un livreur de test
INSERT INTO Livreurs (nom, prenom, telephone, disponible) VALUES
('Diallo', 'Amadou', '+221771234567', TRUE),
('Ba', 'Fatou', '+221771234568', TRUE);

-- ============================================
-- Fin du Script
-- ============================================

