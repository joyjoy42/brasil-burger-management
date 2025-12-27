-- Populate zones table with Dakar's 19 communes d'arrondissement
-- Run this SQL in Neon's SQL Editor after the zones table is created
-- This will insert only zones that don't already exist (safe to run multiple times)

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Dakar-Plateau', 'Dakar-Plateau, Zone du Port, Zone Industrielle', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Dakar-Plateau');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Médina', 'Médina, Sandaga, Kermel', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Médina');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Fass-Gueule Tapée-Colobane', 'Fass, Gueule Tapée, Colobane', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Fass-Gueule Tapée-Colobane');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Fann-Point E-Amitié', 'Fann, Point E, Amitié', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Fann-Point E-Amitié');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Grand Dakar', 'Grand Dakar, Sicap Baobab', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Grand Dakar');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Biscuiterie', 'Biscuiterie, HLM Grand Yoff', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Biscuiterie');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Dieuppeul-Derklé', 'Dieuppeul, Derklé', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Dieuppeul-Derklé');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'HLM', 'HLM, Grand Yoff Extension', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'HLM');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Mermoz-Sacré-Cœur', 'Mermoz, Sacré-Cœur', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Mermoz-Sacré-Cœur');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Ouakam', 'Ouakam, Virage', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Ouakam');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Ngor', 'Ngor, Almadies', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Ngor');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Yoff', 'Yoff, Aéroport', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Yoff');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Grand Yoff', 'Grand Yoff, Cité Keur Gorgui', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Grand Yoff');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Parcelles Assainies', 'Parcelles Assainies, Unité', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Parcelles Assainies');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Cambérène', 'Cambérène, Yeumbeul', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Cambérène');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Pikine-Est', 'Pikine-Est, Thiaroye', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Pikine-Est');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Pikine-Ouest', 'Pikine-Ouest, Guinaw Rails', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Pikine-Ouest');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Pikine-Nord', 'Pikine-Nord, Dalifort', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Pikine-Nord');

INSERT INTO zones (name, neighborhoods, delivery_price)
SELECT 'Patte d''Oie', 'Patte d''Oie, Pikine-Icotaf', 0.00
WHERE NOT EXISTS (SELECT 1 FROM zones WHERE name = 'Patte d''Oie');
