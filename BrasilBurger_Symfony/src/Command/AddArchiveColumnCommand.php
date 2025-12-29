<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:add-archive-column',
    description: 'Add archive column to burgers table',
)]
class AddArchiveColumnCommand extends Command
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
            // Check if archive column already exists
            $io->info('Checking if archive column exists...');
            
            $sql = "SELECT count(*) FROM information_schema.columns 
                    WHERE table_name = 'burgers' AND column_name = 'archive'";
            $exists = $this->connection->fetchOne($sql);

            if ($exists > 0) {
                $io->success('Archive column already exists in burgers table.');
                return Command::SUCCESS;
            }

            // Add the column
            $io->info('Adding archive column to burgers table...');
            $this->connection->executeStatement(
                'ALTER TABLE burgers ADD COLUMN archive BOOLEAN NOT NULL DEFAULT false'
            );

            $io->success('Archive column has been added successfully to the burgers table!');
            $io->note('All existing records have been set to false (active) by default.');
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Failed to add archive column: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}


