<?php
// Script to create zones table
// Access via: http://localhost:8000/create_zones_table.php

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

    // Check if zones table already exists
    $log[] = "Checking if zones table exists...";
    $stmt = $pdo->query("SELECT count(*) FROM information_schema.tables 
                         WHERE table_name = 'zones'");
    $hasZonesTable = $stmt->fetchColumn();

    if (!$hasZonesTable) {
        $log[] = "Creating zones table...";
        $pdo->exec("CREATE TABLE zones (
            id SERIAL PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            neighborhoods TEXT,
            delivery_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00
        )");
        $log[] = "✓ Zones table created successfully!";
        
        echo "<h2>✅ Table Created!</h2>";
        echo "<p><strong>Zones table has been created successfully.</strong></p>";
        echo "<p><a href='/admin/delivery' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Delivery →</a></p>";
    } else {
        $log[] = "⚠ Zones table already exists";
        echo "<h2>✅ Table Already Exists</h2>";
        echo "<p>The zones table already exists in the database.</p>";
        echo "<p><a href='/admin/delivery' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Delivery →</a></p>";
    }

    echo "<hr><details><summary>Creation Log</summary><pre>" . implode("\n", $log) . "</pre></details>";

} catch (Exception $e) {
    $log[] = "❌ ERROR: " . $e->getMessage();
    echo "<h2>❌ Creation Failed</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='/create_zones_table.php'>Try Again</a></p>";
    echo "<hr><details open><summary>Debug Log</summary><pre>" . implode("\n", $log) . "</pre></details>";
}


