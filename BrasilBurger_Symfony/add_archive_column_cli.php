<?php
// CLI script to add archive column to burgers table
// Run: php add_archive_column_cli.php

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

    // Check if archive column already exists
    echo "Checking if archive column exists...\n";
    $stmt = $pdo->query("SELECT count(*) FROM information_schema.columns 
                         WHERE table_name = 'burgers' AND column_name = 'archive'");
    $hasArchiveColumn = $stmt->fetchColumn();

    if (!$hasArchiveColumn) {
        echo "Adding archive column to burgers table...\n";
        $pdo->exec("ALTER TABLE burgers ADD COLUMN archive BOOLEAN NOT NULL DEFAULT false");
        echo "✓ Archive column added successfully!\n";
        echo "The column has been set with default value 'false' for all existing records.\n";
    } else {
        echo "✓ Archive column already exists\n";
    }

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

