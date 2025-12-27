<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SetupController extends AbstractController
{
    #[Route('/setup-admin', name: 'app_setup_admin')]
    public function setup(Connection $connection): Response
    {
        $log = [];
        try {
            // 1. Create Roles table if missing
            $log[] = "Step 1: Creating roles table...";
            $connection->executeStatement("CREATE TABLE IF NOT EXISTS roles (
                id SERIAL PRIMARY KEY,
                name VARCHAR(50) NOT NULL UNIQUE
            )");
            $log[] = "✓ Roles table created/verified";

            // 2. Add role_id to clients if missing
            $log[] = "Step 2: Checking for role_id column...";
            $hasRoleId = $connection->fetchOne("
                SELECT count(*) FROM information_schema.columns 
                WHERE table_name = 'clients' AND column_name = 'role_id'
            ");

            if (!$hasRoleId) {
                $log[] = "Adding role_id column...";
                $connection->executeStatement("ALTER TABLE clients ADD COLUMN role_id INTEGER");
                $log[] = "✓ role_id column added";
                
                $log[] = "Adding foreign key constraint...";
                try {
                    $connection->executeStatement("ALTER TABLE clients ADD CONSTRAINT fk_client_role FOREIGN KEY (role_id) REFERENCES roles(id)");
                    $log[] = "✓ Foreign key constraint added";
                } catch (\Exception $e) {
                    $log[] = "⚠ Foreign key constraint already exists or failed: " . $e->getMessage();
                }
            } else {
                $log[] = "✓ role_id column already exists";
            }

            // 3. Insert roles using raw SQL
            $log[] = "Step 3: Inserting roles...";
            $roleNames = ['client', 'gestionnaire', 'livreur'];
            foreach ($roleNames as $name) {
                try {
                    $connection->executeStatement(
                        "INSERT INTO roles (name) VALUES (?)",
                        [$name]
                    );
                    $log[] = "✓ Role '$name' inserted";
                } catch (\Exception $e) {
                    $log[] = "⚠ Role '$name' already exists";
                }
            }

            // 4. Get gestionnaire role ID
            $log[] = "Step 4: Getting gestionnaire role ID...";
            $gestionnaireRoleId = $connection->fetchOne(
                "SELECT id FROM roles WHERE name = ?",
                ['gestionnaire']
            );
            $log[] = "✓ Gestionnaire role ID: $gestionnaireRoleId";

            // 5. Create Admin user using raw SQL
            $log[] = "Step 5: Creating admin user...";
            $email = 'admin@brasilburger.sn';
            $existingUser = $connection->fetchOne(
                "SELECT id FROM clients WHERE email = ?",
                [$email]
            );

            if (!$existingUser) {
                // Use PHP's native password_hash with bcrypt (Symfony's default)
                $hashedPassword = password_hash('admin123', PASSWORD_BCRYPT);
                
                $connection->executeStatement(
                    "INSERT INTO clients (prenom, nom, email, password, role_id, created_at) 
                     VALUES (?, ?, ?, ?, ?, NOW())",
                    ['Admin', 'Gestionnaire', $email, $hashedPassword, $gestionnaireRoleId]
                );
                $log[] = "✓ Admin user created successfully!";
                
                return new Response(
                    "<h2>✅ Setup Complete!</h2>" .
                    "<p><strong>Admin user created successfully!</strong></p>" .
                    "<p>You can now log in with:</p>" .
                    "<ul><li>📧 Email: <strong>$email</strong></li>" .
                    "<li>🔑 Password: <strong>admin123</strong></li></ul>" .
                    "<p><a href='/login' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Login →</a></p>" .
                    "<hr><details><summary>Setup Log</summary><pre>" . implode("\n", $log) . "</pre></details>"
                );
            }

            $log[] = "⚠ Admin user already exists";
            return new Response(
                "<h2>✅ Database Already Configured</h2>" .
                "<p>Try logging in with:</p>" .
                "<ul><li>📧 Email: <strong>$email</strong></li>" .
                "<li>🔑 Password: <strong>admin123</strong></li></ul>" .
                "<p><a href='/login' style='padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px;'>Go to Login →</a></p>" .
                "<hr><details><summary>Setup Log</summary><pre>" . implode("\n", $log) . "</pre></details>"
            );

        } catch (\Exception $e) {
            $log[] = "❌ ERROR: " . $e->getMessage();
            $log[] = "Stack trace: " . $e->getTraceAsString();
            return new Response(
                "<h2>❌ Setup Failed</h2>" .
                "<p><strong>Error:</strong> " . htmlspecialchars($e->getMessage()) . "</p>" .
                "<p><a href='/setup-admin'>Try Again</a></p>" .
                "<hr><details open><summary>Debug Log</summary><pre>" . implode("\n", $log) . "</pre></details>"
            );
        }
    }
}
