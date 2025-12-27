<?php

namespace App\Controller;

use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableDiscoveryController extends AbstractController
{
    #[Route('/discover-db', name: 'app_discover_db')]
    public function discover(Connection $connection): Response
    {
        try {
            $tables = $connection->fetchAllAssociative("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");
            $tableList = array_column($tables, 'table_name');
            
            $output = "Available tables: " . implode(', ', $tableList) . "\n\n";
            
            foreach ($tableList as $table) {
                $columns = $connection->fetchAllAssociative("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = '$table'");
                $output .= "Table: $table\n";
                foreach ($columns as $col) {
                    $output .= "  - " . $col['column_name'] . " (" . $col['data_type'] . ")\n";
                }
                $output .= "\n";
            }
            
            return new Response("<pre>$output</pre>");
        } catch (\Exception $e) {
            return new Response("Error: " . $e->getMessage());
        }
    }
}
