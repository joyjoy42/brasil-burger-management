-- Create zones table
-- Run this SQL directly on your PostgreSQL database

CREATE TABLE IF NOT EXISTS zones (
    id SERIAL PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    neighborhoods TEXT,
    delivery_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00
);


