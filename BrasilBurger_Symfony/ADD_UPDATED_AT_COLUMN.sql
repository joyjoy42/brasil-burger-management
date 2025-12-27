-- Add updated_at column to commandes table
-- Run this SQL in Neon's SQL Editor

ALTER TABLE commandes ADD COLUMN IF NOT EXISTS date_modification TIMESTAMP NULL;

