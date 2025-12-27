<?php
// CLI script to create zones table
// Run: php create_zones_table_cli.php

// Get database URL from environment or use default
$databaseUrl = getenv('DATABASE_URL') ?: 'postgresql://neondb_owner:npg_Q28lkcThzxRG@ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech:5432/neondb?sslmode=require';

// Parse the database URL
$parts = parse_url($databaseUrl);
$host = $parts['host'];
$port = $parts['port'] ?? 5432;
$dbname = ltrim($parts['path'], '/');
$user = $parts['user'];
$password = $parts['pass'];

try {
    echo "Connecting to database...\n";
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "✓ Connected to database\n";

    // Check if zones table already exists
    echo "Checking if zones table exists...\n";
    $stmt = $pdo->query("SELECT count(*) FROM information_schema.tables 
                         WHERE table_name = 'zones'");
    $hasZonesTable = $stmt->fetchColumn();

    if (!$hasZonesTable) {
        echo "Creating zones table...\n";
        $pdo->exec("CREATE TABLE zones (
            id SERIAL PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            neighborhoods TEXT,
            delivery_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00
        )");
        echo "✓ Zones table created successfully!\n";
    } else {
        echo "✓ Zones table already exists\n";
    }

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

