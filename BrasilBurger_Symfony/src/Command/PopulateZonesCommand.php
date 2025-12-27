<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:populate-zones',
    description: 'Populate zones table with Dakar\'s 19 communes d\'arrondissement',
)]
class PopulateZonesCommand extends Command
{
    public function __construct(
        private Connection $connection
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

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

        try {
            $io->info('Populating zones table with Dakar\'s 19 communes d\'arrondissement...');

            $inserted = 0;
            $skipped = 0;

            foreach ($zones as $zone) {
                // Check if zone already exists
                $exists = $this->connection->fetchOne(
                    'SELECT id FROM zones WHERE name = ?',
                    [$zone['name']]
                );

                if ($exists) {
                    $skipped++;
                    $io->note("Zone '{$zone['name']}' already exists, skipping");
                    continue;
                }

                // Insert the zone
                $this->connection->executeStatement(
                    'INSERT INTO zones (name, neighborhoods, delivery_price) VALUES (?, ?, ?)',
                    [$zone['name'], $zone['neighborhoods'], $zone['delivery_price']]
                );

                $inserted++;
                $io->text("✓ Inserted: {$zone['name']}");
            }

            $io->success("Zones populated successfully! Inserted: $inserted new zones, Skipped: $skipped existing zones");
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Failed to populate zones: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}

