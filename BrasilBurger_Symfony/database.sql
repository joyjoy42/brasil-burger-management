-- Base de données Brasil Burger Management
-- Création des tables selon le cahier des charges

-- Table des burgers
CREATE TABLE burger (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    image VARCHAR(500),
    archive BOOLEAN DEFAULT FALSE
);

-- Table des compléments (frites, boissons)
CREATE TABLE complement (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    image VARCHAR(500),
    archive BOOLEAN DEFAULT FALSE
);

-- Table des menus
CREATE TABLE menu (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(255) NOT NULL,
    image VARCHAR(500),
    archive BOOLEAN DEFAULT FALSE
);

-- Table de liaison Menu-Items (composition des menus)
CREATE TABLE menu_item (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    menu_id INTEGER NOT NULL,
    burger_id INTEGER,
    complement_id INTEGER,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (burger_id) REFERENCES burger(id) ON DELETE CASCADE,
    FOREIGN KEY (complement_id) REFERENCES complement(id) ON DELETE CASCADE
);

-- Table des zones de livraison
CREATE TABLE zone_livraison (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(255) NOT NULL,
    prix_livraison DECIMAL(10,2) NOT NULL,
    quartiers TEXT NOT NULL
);

-- Table des clients
CREATE TABLE client (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table des gestionnaires
CREATE TABLE gestionnaire (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Table des commandes
CREATE TABLE commande (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_id INTEGER NOT NULL,
    type_commande VARCHAR(20) NOT NULL CHECK (type_commande IN ('sur_place', 'a_emporter', 'livraison')),
    statut VARCHAR(20) DEFAULT 'en_attente' CHECK (statut IN ('en_attente', 'valide', 'preparation', 'prete', 'termine', 'annule')),
    montant_total DECIMAL(10,2) NOT NULL,
    date_commande DATETIME NOT NULL,
    zone_livraison_id INTEGER,
    FOREIGN KEY (client_id) REFERENCES client(id) ON DELETE CASCADE,
    FOREIGN KEY (zone_livraison_id) REFERENCES zone_livraison(id) ON DELETE SET NULL
);

-- Table des items de commande
CREATE TABLE commande_item (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    commande_id INTEGER NOT NULL,
    burger_id INTEGER,
    menu_id INTEGER,
    complement_id INTEGER,
    quantite INTEGER NOT NULL,
    prix_unitaire DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE,
    FOREIGN KEY (burger_id) REFERENCES burger(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE,
    FOREIGN KEY (complement_id) REFERENCES complement(id) ON DELETE CASCADE
);

-- Table des paiements
CREATE TABLE paiement (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    commande_id INTEGER UNIQUE NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    methode VARCHAR(20) NOT NULL CHECK (methode IN ('wave', 'om')),
    date_paiement DATETIME NOT NULL,
    reference_transaction VARCHAR(255),
    FOREIGN KEY (commande_id) REFERENCES commande(id) ON DELETE CASCADE
);

-- Index pour optimiser les performances
CREATE INDEX idx_burger_archive ON burger(archive);
CREATE INDEX idx_complement_archive ON complement(archive);
CREATE INDEX idx_menu_archive ON menu(archive);
CREATE INDEX idx_commande_client ON commande(client_id);
CREATE INDEX idx_commande_date ON commande(date_commande);
CREATE INDEX idx_commande_statut ON commande(statut);
CREATE INDEX idx_commande_item_commande ON commande_item(commande_id);
CREATE INDEX idx_menu_item_menu ON menu_item(menu_id);

-- Insertion de données de test
INSERT INTO burger (nom, prix, image) VALUES 
('Classic Burger', 2500, 'images/classic-burger.jpg'),
('Cheese Burger', 2800, 'images/cheese-burger.jpg'),
('Bacon Burger', 3200, 'images/bacon-burger.jpg'),
('Veggie Burger', 2200, 'images/veggie-burger.jpg'),
('Chicken Burger', 2600, 'images/chicken-burger.jpg');

INSERT INTO complement (nom, prix, image) VALUES 
('Frites', 800, 'images/frites.jpg'),
('Frites avec fromage', 1200, 'images/frites-fromage.jpg'),
('Coca Cola', 500, 'images/coca.jpg'),
('Sprite', 500, 'images/sprite.jpg'),
('Eau minérale', 300, 'images/eau.jpg'),
('Jus d''orange', 600, 'images/jus-orange.jpg');

INSERT INTO menu (nom, image) VALUES 
('Menu Classic', 'images/menu-classic.jpg'),
('Menu Deluxe', 'images/menu-deluxe.jpg'),
('Menu Kids', 'images/menu-kids.jpg');

-- Composition des menus
INSERT INTO menu_item (menu_id, burger_id, complement_id) VALUES 
(1, 1, 1), -- Menu Classic: Classic Burger + Frites
(1, 1, 3), -- Menu Classic: Classic Burger + Coca Cola
(2, 2, 2), -- Menu Deluxe: Cheese Burger + Frites avec fromage
(2, 2, 4), -- Menu Deluxe: Cheese Burger + Sprite
(3, 4, 1), -- Menu Kids: Veggie Burger + Frites
(3, 4, 6); -- Menu Kids: Veggie Burger + Jus d'orange

INSERT INTO zone_livraison (nom, prix_livraison, quartiers) VALUES 
('Zone Centre', 1000, 'Plateau, Centre-ville, Fass'),
('Zone Nord', 1500, 'Pikine, Guédiawaye, Yeumbeul'),
(' Zone Sud', 1200, 'Mermoz, Ouakam, Almadies'),
('Zone Est', 1300, 'Parcelles, Grand Yoff, Dieuppeul');

-- Insertion d'un gestionnaire par défaut (mot de passe: admin123)
INSERT INTO gestionnaire (nom, prenom, email, password) VALUES 
('Admin', 'Système', 'admin@brasilburger.sn', '$2y$13$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insertion de clients de test
INSERT INTO client (nom, prenom, telephone, email, password) VALUES 
('Ndiaye', 'Moussa', '771234567', 'moussa.ndiaye@email.com', '$2y$13$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Fall', 'Fatou', '772345678', 'fatou.fall@email.com', '$2y$13$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Sarr', 'Ibrahim', '773456789', 'ibrahim.sarr@email.com', '$2y$13$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
