<?php

namespace App\DataFixtures;

use App\Entity\Burger;
use App\Entity\Client;
use App\Entity\Complement;
use App\Entity\Gestionnaire;
use App\Entity\Menu;
use App\Entity\MenuItem;
use App\Entity\ZoneLivraison;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création des burgers
        $burgers = [
            ['Classic Burger', 2500, 'images/classic-burger.jpg'],
            ['Cheese Burger', 2800, 'images/cheese-burger.jpg'],
            ['Bacon Burger', 3200, 'images/bacon-burger.jpg'],
            ['Veggie Burger', 2200, 'images/veggie-burger.jpg'],
            ['Chicken Burger', 2600, 'images/chicken-burger.jpg'],
        ];

        foreach ($burgers as [$nom, $prix, $image]) {
            $burger = new Burger();
            $burger->setNom($nom);
            $burger->setPrix($prix);
            $burger->setImage($image);
            $burger->setArchive(false);
            $manager->persist($burger);
        }

        // Création des compléments
        $complements = [
            ['Frites', 800, 'images/frites.jpg'],
            ['Frites avec fromage', 1200, 'images/frites-fromage.jpg'],
            ['Coca Cola', 500, 'images/coca.jpg'],
            ['Sprite', 500, 'images/sprite.jpg'],
            ['Eau minérale', 300, 'images/eau.jpg'],
            ['Jus d\'orange', 600, 'images/jus-orange.jpg'],
        ];

        foreach ($complements as [$nom, $prix, $image]) {
            $complement = new Complement();
            $complement->setNom($nom);
            $complement->setPrix($prix);
            $complement->setImage($image);
            $complement->setArchive(false);
            $manager->persist($complement);
        }

        $manager->flush();

        // Récupérer les entités pour les relations
        $burgerRepo = $manager->getRepository(Burger::class);
        $complementRepo = $manager->getRepository(Complement::class);

        $classicBurger = $burgerRepo->findOneBy(['nom' => 'Classic Burger']);
        $cheeseBurger = $burgerRepo->findOneBy(['nom' => 'Cheese Burger']);
        $veggieBurger = $burgerRepo->findOneBy(['nom' => 'Veggie Burger']);

        $frites = $complementRepo->findOneBy(['nom' => 'Frites']);
        $fritesFromage = $complementRepo->findOneBy(['nom' => 'Frites avec fromage']);
        $coca = $complementRepo->findOneBy(['nom' => 'Coca Cola']);
        $sprite = $complementRepo->findOneBy(['nom' => 'Sprite']);
        $jusOrange = $complementRepo->findOneBy(['nom' => 'Jus d\'orange']);

        // Création des menus
        $menus = [
            ['Menu Classic', 'images/menu-classic.jpg'],
            ['Menu Deluxe', 'images/menu-deluxe.jpg'],
            ['Menu Kids', 'images/menu-kids.jpg'],
        ];

        foreach ($menus as [$nom, $image]) {
            $menu = new Menu();
            $menu->setNom($nom);
            $menu->setImage($image);
            $menu->setArchive(false);
            $manager->persist($menu);
        }

        $manager->flush();

        // Composition des menus
        $menuRepo = $manager->getRepository(Menu::class);
        $menuClassic = $menuRepo->findOneBy(['nom' => 'Menu Classic']);
        $menuDeluxe = $menuRepo->findOneBy(['nom' => 'Menu Deluxe']);
        $menuKids = $menuRepo->findOneBy(['nom' => 'Menu Kids']);

        // Menu Classic: Classic Burger + Frites + Coca Cola
        $menuItem1 = new MenuItem();
        $menuItem1->setMenu($menuClassic);
        $menuItem1->setBurger($classicBurger);
        $manager->persist($menuItem1);

        $menuItem2 = new MenuItem();
        $menuItem2->setMenu($menuClassic);
        $menuItem2->setComplement($frites);
        $manager->persist($menuItem2);

        $menuItem3 = new MenuItem();
        $menuItem3->setMenu($menuClassic);
        $menuItem3->setComplement($coca);
        $manager->persist($menuItem3);

        // Menu Deluxe: Cheese Burger + Frites avec fromage + Sprite
        $menuItem4 = new MenuItem();
        $menuItem4->setMenu($menuDeluxe);
        $menuItem4->setBurger($cheeseBurger);
        $manager->persist($menuItem4);

        $menuItem5 = new MenuItem();
        $menuItem5->setMenu($menuDeluxe);
        $menuItem5->setComplement($fritesFromage);
        $manager->persist($menuItem5);

        $menuItem6 = new MenuItem();
        $menuItem6->setMenu($menuDeluxe);
        $menuItem6->setComplement($sprite);
        $manager->persist($menuItem6);

        // Menu Kids: Veggie Burger + Frites + Jus d'orange
        $menuItem7 = new MenuItem();
        $menuItem7->setMenu($menuKids);
        $menuItem7->setBurger($veggieBurger);
        $manager->persist($menuItem7);

        $menuItem8 = new MenuItem();
        $menuItem8->setMenu($menuKids);
        $menuItem8->setComplement($frites);
        $manager->persist($menuItem8);

        $menuItem9 = new MenuItem();
        $menuItem9->setMenu($menuKids);
        $menuItem9->setComplement($jusOrange);
        $manager->persist($menuItem9);

        // Création des zones de livraison
        $zones = [
            ['Zone Centre', 1000, 'Plateau,Centre-ville,Fass'],
            ['Zone Nord', 1500, 'Pikine,Guédiawaye,Yeumbeul'],
            ['Zone Sud', 1200, 'Mermoz,Ouakam,Almadies'],
            ['Zone Est', 1300, 'Parcelles,Grand Yoff,Dieuppeul'],
        ];

        foreach ($zones as [$nom, $prix, $quartiers]) {
            $zone = new ZoneLivraison();
            $zone->setNom($nom);
            $zone->setPrixLivraison($prix);
            $zone->setQuartiers($quartiers);
            $manager->persist($zone);
        }

        // Création du gestionnaire par défaut
        $gestionnaire = new Gestionnaire();
        $gestionnaire->setNom('Admin');
        $gestionnaire->setPrenom('Système');
        $gestionnaire->setEmail('admin@brasilburger.sn');
        $gestionnaire->setPassword($this->passwordHasher->hashPassword($gestionnaire, 'admin123'));
        $manager->persist($gestionnaire);

        // Création de clients de test
        $clients = [
            ['Ndiaye', 'Moussa', '771234567', 'moussa.ndiaye@email.com'],
            ['Fall', 'Fatou', '772345678', 'fatou.fall@email.com'],
            ['Sarr', 'Ibrahim', '773456789', 'ibrahim.sarr@email.com'],
        ];

        foreach ($clients as [$nom, $prenom, $telephone, $email]) {
            $client = new Client();
            $client->setNom($nom);
            $client->setPrenom($prenom);
            $client->setTelephone($telephone);
            $client->setEmail($email);
            $client->setPassword($this->passwordHasher->hashPassword($client, 'password'));
            $manager->persist($client);
        }

        $manager->flush();
    }
}
