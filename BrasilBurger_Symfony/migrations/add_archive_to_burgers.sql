-- Migration: Add archive column to burgers table
-- Run this SQL directly on your PostgreSQL database

ALTER TABLE burgers ADD COLUMN archive BOOLEAN NOT NULL DEFAULT false;

