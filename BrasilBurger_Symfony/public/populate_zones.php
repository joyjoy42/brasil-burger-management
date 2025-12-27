<?php
// Script to populate zones table with Dakar's 19 communes d'arrondissement
// Access via: http://localhost:8000/populate_zones.php

// Get database URL from environment
$databaseUrl = getenv('DATABASE_URL') ?: 'postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech:5432/neondb?sslmode=require';

// Parse the database URL
$parts = parse_url($databaseUrl);
$host = $parts['host'];
$port = $parts['port'] ?? 5432;
$dbname = ltrim($parts['path'], '/');
$user = $parts['user'];
$password = $parts['pass'];

$log = [];

try {
    // Connect to PostgreSQL
    $log[] = "Connecting to database...";
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $log[] = "✓ Connected to database";

    // Check if zones table exists
    $log[] = "Checking if zones table exists...";
    $stmt = $pdo->query("SELECT count(*) FROM information_schema.tables 
                         WHERE table_name = 'zones'");
    $hasZonesTable = $stmt->fetchColumn();

    if (!$hasZonesTable) {
        $log[] = "❌ Zones table does not exist. Please create it first.";
        echo "<h2>❌ Table Not Found</h2>";
        echo "<p>The zones table does not exist. Please create it first.</p>";
        echo "<p><a href='/create_zones_table.php'>Create Zones Table →</a></p>";
        echo "<hr><details open><summary>Log</summary><pre>" . implode("\n", $log) . "</pre></details>";
        exit;
    }

    // Check current count
    $stmt = $pdo->query("SELECT count(*) FROM zones");
    $currentCount = $stmt->fetchColumn();
    $log[] = "Current zones count: $currentCount";

    // Define the 19 zones of Dakar
    $zones = [
        ['name' => 'Dakar-Plateau', 'neighborhoods' => 'Dakar-Plateau, Zone du Port, Zone Industrielle', 'delivery_price' => 0.00],
        ['name' => 'Médina', 'neighborhoods' => 'Médina, Sandaga, Kermel', 'delivery_price' => 0.00],
        ['name' => 'Fass-Gueule Tapée-Colobane', 'neighborhoods' => 'Fass, Gueule Tapée, Colobane', 'delivery_price' => 0.00],
        ['name' => 'Fann-Point E-Amitié', 'neighborhoods' => 'Fann, Point E, Amitié', 'delivery_price' => 0.00],
        ['name' => 'Grand Dakar', 'neighborhoods' => 'Grand Dakar, Sicap Baobab', 'delivery_price' => 0.00],
        ['name' => 'Biscuiterie', 'neighborhoods' => 'Biscuiterie, HLM Grand Yoff', 'delivery_price' => 0.00],
        ['name' => 'Dieuppeul-Derklé', 'neighborhoods' => 'Dieuppeul, Derklé', 'delivery_price' => 0.00],
        ['name' => 'HLM', 'neighborhoods' => 'HLM, Grand Yoff Extension', 'delivery_price' => 0.00],
        ['name' => 'Mermoz-Sacré-Cœur', 'neighborhoods' => 'Mermoz, Sacré-Cœur', 'delivery_price' => 0.00],
        ['name' => 'Ouakam', 'neighborhoods' => 'Ouakam, Virage', 'delivery_price' => 0.00],
        ['name' => 'Ngor', 'neighborhoods' => 'Ngor, Almadies', 'delivery_price' => 0.00],
        ['name' => 'Yoff', 'neighborhoods' => 'Yoff, Aéroport', 'delivery_price' => 0.00],
        ['name' => 'Grand Yoff', 'neighborhoods' => 'Grand Yoff, Cité Keur Gorgui', 'delivery_price' => 0.00],
        ['name' => 'Parcelles Assainies', 'neighborhoods' => 'Parcelles Assainies, Unité', 'delivery_price' => 0.00],
        ['name' => 'Cambérène', 'neighborhoods' => 'Cambérène, Yeumbeul', 'delivery_price' => 0.00],
        ['name' => 'Pikine-Est', 'neighborhoods' => 'Pikine-Est, Thiaroye', 'delivery_price' => 0.00],
        ['name' => 'Pikine-Ouest', 'neighborhoods' => 'Pikine-Ouest, Guinaw Rails', 'delivery_price' => 0.00],
        ['name' => 'Pikine-Nord', 'neighborhoods' => 'Pikine-Nord, Dalifort', 'delivery_price' => 0.00],
        ['name' => 'Patte d\'Oie', 'neighborhoods' => 'Patte d\'Oie, Pikine-Icotaf', 'delivery_price' => 0.00],
    ];

    $log[] = "Inserting 19 zones...";
    $inserted = 0;
    $skipped = 0;

    $stmt = $pdo->prepare("INSERT INTO zones (name, neighborhoods, delivery_price) 
                           VALUES (?, ?, ?) 
                           ON CONFLICT (id) DO NOTHING");

    foreach ($zones as $zone) {
        try {
            // Check if zone already exists by name
            $checkStmt = $pdo->prepare("SELECT id FROM zones WHERE name = ?");
            $checkStmt->execute([$zone['name']]);
            if ($checkStmt->fetchColumn()) {
                $skipped++;
                $log[] = "⚠ Zone '{$zone['name']}' already exists, skipping";
                continue;
            }

            $stmt->execute([$zone['name'], $zone['neighborhoods'], $zone['delivery_price']]);
            $inserted++;
            $log[] = "✓ Inserted: {$zone['name']}";
        } catch (Exception $e) {
            $log[] = "⚠ Error inserting {$zone['name']}: " . $e->getMessage();
        }
    }

    $log[] = "✓ Insertion complete: $inserted new zones, $skipped already existing";
    
    echo "<h2>✅ Zones Populated!</h2>";
    echo "<p><strong>Successfully processed zones:</strong></p>";
    echo "<ul><li>Inserted: <strong>$inserted</strong> new zones</li>";
    echo "<li>Skipped: <strong>$skipped</strong> existing zones</li></ul>";
    echo "<p><a href='/admin/delivery' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Delivery →</a></p>";

    echo "<hr><details><summary>Insertion Log</summary><pre>" . implode("\n", $log) . "</pre></details>";

} catch (Exception $e) {
    $log[] = "❌ ERROR: " . $e->getMessage();
    echo "<h2>❌ Population Failed</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='/populate_zones.php'>Try Again</a></p>";
    echo "<hr><details open><summary>Debug Log</summary><pre>" . implode("\n", $log) . "</pre></details>";
}

