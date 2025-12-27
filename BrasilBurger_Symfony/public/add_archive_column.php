<?php
// Script to add archive column to burgers table
// Access via: http://localhost:8000/add_archive_column.php

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

    // Check if archive column already exists
    $log[] = "Checking if archive column exists...";
    $stmt = $pdo->query("SELECT count(*) FROM information_schema.columns 
                         WHERE table_name = 'burgers' AND column_name = 'archive'");
    $hasArchiveColumn = $stmt->fetchColumn();

    if (!$hasArchiveColumn) {
        $log[] = "Adding archive column to burgers table...";
        $pdo->exec("ALTER TABLE burgers ADD COLUMN archive BOOLEAN NOT NULL DEFAULT false");
        $log[] = "✓ Archive column added successfully!";
        
        echo "<h2>✅ Migration Complete!</h2>";
        echo "<p><strong>Archive column has been added to the burgers table.</strong></p>";
        echo "<p>The column has been set with default value 'false' for all existing records.</p>";
        echo "<p><a href='/admin/catalog' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Catalog →</a></p>";
    } else {
        $log[] = "⚠ Archive column already exists";
        echo "<h2>✅ Column Already Exists</h2>";
        echo "<p>The archive column already exists in the burgers table.</p>";
        echo "<p><a href='/admin/catalog' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Catalog →</a></p>";
    }

    echo "<hr><details><summary>Migration Log</summary><pre>" . implode("\n", $log) . "</pre></details>";

} catch (Exception $e) {
    $log[] = "❌ ERROR: " . $e->getMessage();
    echo "<h2>❌ Migration Failed</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='/add_archive_column.php'>Try Again</a></p>";
    echo "<hr><details open><summary>Debug Log</summary><pre>" . implode("\n", $log) . "</pre></details>";
}

