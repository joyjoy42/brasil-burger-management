<?php
// Standalone database setup script
// Access via: http://localhost:8000/setup_db.php

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

    // 1. Create Roles table
    $log[] = "Creating roles table...";
    $pdo->exec("CREATE TABLE IF NOT EXISTS roles (
        id SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE
    )");
    $log[] = "✓ Roles table created/verified";

    // 2. Check and add role_id column to clients
    $log[] = "Checking for role_id column...";
    $stmt = $pdo->query("SELECT count(*) FROM information_schema.columns 
                         WHERE table_name = 'clients' AND column_name = 'role_id'");
    $hasRoleId = $stmt->fetchColumn();

    if (!$hasRoleId) {
        $log[] = "Adding role_id column...";
        $pdo->exec("ALTER TABLE clients ADD COLUMN role_id INTEGER");
        $log[] = "✓ role_id column added";
        
        try {
            $pdo->exec("ALTER TABLE clients ADD CONSTRAINT fk_client_role 
                       FOREIGN KEY (role_id) REFERENCES roles(id)");
            $log[] = "✓ Foreign key constraint added";
        } catch (Exception $e) {
            $log[] = "⚠ Foreign key constraint already exists";
        }
    } else {
        $log[] = "✓ role_id column already exists";
    }

    // 3. Insert roles
    $log[] = "Inserting roles...";
    $roleNames = ['client', 'gestionnaire', 'livreur'];
    foreach ($roleNames as $name) {
        try {
            $stmt = $pdo->prepare("INSERT INTO roles (name) VALUES (?)");
            $stmt->execute([$name]);
            $log[] = "✓ Role '$name' inserted";
        } catch (Exception $e) {
            $log[] = "⚠ Role '$name' already exists";
        }
    }

    // 4. Get gestionnaire role ID
    $log[] = "Getting gestionnaire role ID...";
    $stmt = $pdo->prepare("SELECT id FROM roles WHERE name = ?");
    $stmt->execute(['gestionnaire']);
    $gestionnaireRoleId = $stmt->fetchColumn();
    $log[] = "✓ Gestionnaire role ID: $gestionnaireRoleId";

    // 5. Create admin user
    $log[] = "Creating admin user...";
    $email = 'admin@brasilburger.sn';
    
    $stmt = $pdo->prepare("SELECT id FROM clients WHERE email = ?");
    $stmt->execute([$email]);
    $existingUser = $stmt->fetchColumn();

    if (!$existingUser) {
        $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
        
        $stmt = $pdo->prepare("INSERT INTO clients (prenom, nom, telephone, email, password, role_id, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->execute(['Admin', 'Gestionnaire', '+221000000000', $email, $hashedPassword, $gestionnaireRoleId]);
        $log[] = "✓ Admin user created successfully!";
        
        echo "<h2>✅ Setup Complete!</h2>";
        echo "<p><strong>Admin user created successfully!</strong></p>";
        echo "<p>You can now log in with:</p>";
        echo "<ul><li>📧 Email: <strong>$email</strong></li>";
        echo "<li>🔑 Password: <strong>admin123</strong></li></ul>";
        echo "<p><a href='/login' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Login →</a></p>";
    } else {
        $log[] = "⚠ Admin user already exists";
        echo "<h2>✅ Database Already Configured</h2>";
        echo "<p>Try logging in with:</p>";
        echo "<ul><li>📧 Email: <strong>$email</strong></li>";
        echo "<li>🔑 Password: <strong>admin123</strong></li></ul>";
        echo "<p><a href='/login' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Login →</a></p>";
    }

    echo "<hr><details><summary>Setup Log</summary><pre>" . implode("\n", $log) . "</pre></details>";

} catch (Exception $e) {
    $log[] = "❌ ERROR: " . $e->getMessage();
    echo "<h2>❌ Setup Failed</h2>";
    echo "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<p><a href='/setup_db.php'>Try Again</a></p>";
    echo "<hr><details open><summary>Debug Log</summary><pre>" . implode("\n", $log) . "</pre></details>";
}
