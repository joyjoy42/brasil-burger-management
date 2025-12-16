-- Schema initial pour Brasil Burger Management
-- Tables principales : roles, users, burgers, complements, menus, menu_items, orders, order_items, payments, zones, delivery_assignments

CREATE TABLE roles (
  id SERIAL PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE -- e.g. 'client', 'gestionnaire', 'livreur'
);

CREATE TABLE users (
  id SERIAL PRIMARY KEY,
  role_id INT REFERENCES roles(id),
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  phone VARCHAR(20) UNIQUE,
  email VARCHAR(150) UNIQUE,
  password_hash VARCHAR(255),
  created_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE burgers (
  id SERIAL PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  description TEXT,
  price NUMERIC(10,2) NOT NULL,
  image_url TEXT,
  archived BOOLEAN DEFAULT FALSE
);

CREATE TABLE complements (
  id SERIAL PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  price NUMERIC(10,2) NOT NULL,
  image_url TEXT,
  archived BOOLEAN DEFAULT FALSE
);

CREATE TABLE menus (
  id SERIAL PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  image_url TEXT,
  archived BOOLEAN DEFAULT FALSE
);

CREATE TABLE menu_items (
  id SERIAL PRIMARY KEY,
  menu_id INT REFERENCES menus(id) ON DELETE CASCADE,
  burger_id INT REFERENCES burgers(id),
  complement_id INT REFERENCES complements(id),
  -- item_price stored for historical integrity (price when menu was created / sold)
  item_price NUMERIC(10,2)
);

CREATE TABLE zones (
  id SERIAL PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  neighborhoods TEXT, -- description or JSON for multiple quartiers
  delivery_price NUMERIC(10,2) DEFAULT 0.00
);

CREATE TABLE orders (
  id SERIAL PRIMARY KEY,
  user_id INT REFERENCES users(id),
  type VARCHAR(20) NOT NULL, -- 'sur_place','retrait','livraison'
  status VARCHAR(50) NOT NULL, -- e.g. 'en_attente','valide','annule','termine'
  total_amount NUMERIC(10,2) NOT NULL,
  zone_id INT REFERENCES zones(id),
  created_at TIMESTAMP DEFAULT NOW(),
  updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE order_items (
  id SERIAL PRIMARY KEY,
  order_id INT REFERENCES orders(id) ON DELETE CASCADE,
  burger_id INT REFERENCES burgers(id),
  menu_id INT REFERENCES menus(id),
  complement_id INT REFERENCES complements(id),
  quantity INT DEFAULT 1,
  unit_price NUMERIC(10,2) NOT NULL
);

CREATE TABLE payments (
  id SERIAL PRIMARY KEY,
  order_id INT REFERENCES orders(id) UNIQUE, -- une commande payée une seule fois
  method VARCHAR(50) NOT NULL, -- 'Wave','OM', etc.
  amount NUMERIC(10,2) NOT NULL,
  paid_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE delivery_assignments (
  id SERIAL PRIMARY KEY,
  order_id INT REFERENCES orders(id) UNIQUE,
  livrer_id INT REFERENCES users(id), -- user with role 'livreur'
  assigned_at TIMESTAMP DEFAULT NOW()
);

-- Indexes utiles
CREATE INDEX idx_orders_created_at ON orders(created_at);
CREATE INDEX idx_orders_status ON orders(status);
CREATE INDEX idx_order_items_order ON order_items(order_id);
