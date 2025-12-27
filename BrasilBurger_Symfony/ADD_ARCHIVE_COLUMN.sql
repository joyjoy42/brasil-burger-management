-- Run this SQL command on your PostgreSQL database to add the archive column
-- Copy and paste this into your database management tool

ALTER TABLE burgers ADD COLUMN archive BOOLEAN NOT NULL DEFAULT false;

