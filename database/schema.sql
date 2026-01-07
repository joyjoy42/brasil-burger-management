-- Database Schema for Brasil Burger
-- Shared across Java, C# ASP.NET MVC, and Symfony

CREATE TYPE user_role AS ENUM ('CLIENT', 'GESTIONNAIRE', 'LIVREUR');
CREATE TYPE order_status AS ENUM ('PENDING', 'PAID', 'READY', 'FINISHED', 'DELIVERED', 'CANCELLED');
CREATE TYPE order_type AS ENUM ('SUR_PLACE', 'A_EMPORTER', 'LIVRAISON');
CREATE TYPE product_type AS ENUM ('BURGER', 'COMPLEMENT');

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    login VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role user_role NOT NULL,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    telephone VARCHAR(20),
    adresse TEXT
);

CREATE TABLE zones (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    frais_livraison DECIMAL(10, 2) NOT NULL
);

CREATE TABLE products (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prix DECIMAL(10, 2), -- Only for burgers and complements
    type product_type NOT NULL,
    image TEXT,
    est_archive BOOLEAN DEFAULT FALSE
);

CREATE TABLE menus (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    image TEXT,
    est_archive BOOLEAN DEFAULT FALSE
);

CREATE TABLE menu_items (
    menu_id INTEGER REFERENCES menus(id),
    product_id INTEGER REFERENCES products(id),
    quantite INTEGER DEFAULT 1,
    PRIMARY KEY (menu_id, product_id)
);

CREATE TABLE commandes (
    id SERIAL PRIMARY KEY,
    client_id INTEGER REFERENCES users(id),
    zone_id INTEGER REFERENCES zones(id),
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    etat order_status DEFAULT 'PENDING',
    type_commande order_type NOT NULL,
    prix_total DECIMAL(10, 2) NOT NULL,
    livreur_id INTEGER REFERENCES users(id) -- Assigned driver
);

CREATE TABLE commande_details (
    id SERIAL PRIMARY KEY,
    commande_id INTEGER REFERENCES commandes(id),
    product_id INTEGER REFERENCES products(id), -- Null if it's a menu
    menu_id INTEGER REFERENCES menus(id), -- Null if it's a product
    quantite INTEGER NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL
);
