<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-zones-table',
    description: 'Create zones table in the database',
)]
class CreateZonesTableCommand extends Command
{
    public function __construct(
        private Connection $connection
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            // Check if zones table already exists
            $io->info('Checking if zones table exists...');
            
            $sql = "SELECT count(*) FROM information_schema.tables 
                    WHERE table_name = 'zones'";
            $exists = $this->connection->fetchOne($sql);

            if ($exists > 0) {
                $io->success('Zones table already exists.');
                return Command::SUCCESS;
            }

            // Create the table
            $io->info('Creating zones table...');
            $this->connection->executeStatement(
                "CREATE TABLE zones (
                    id SERIAL PRIMARY KEY,
                    name VARCHAR(150) NOT NULL,
                    neighborhoods TEXT,
                    delivery_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00
                )"
            );

            $io->success('Zones table has been created successfully!');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Failed to create zones table: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

