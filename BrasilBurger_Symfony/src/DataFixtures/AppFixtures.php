<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        // 1. Create Roles
        $roleNames = ['client', 'gestionnaire', 'livreur'];
        $roles = [];

        foreach ($roleNames as $name) {
            $role = new Role();
            $role->setName($name);
            $manager->persist($role);
            $roles[$name] = $role;
        }

        // 2. Create a default Gestionnaire user
        $admin = new User();
        $admin->setRole($roles['gestionnaire']);
        $admin->setFirstName('Admin');
        $admin->setLastName('Gestionnaire');
        $admin->setEmail('admin@brasilburger.sn');
        
        $hashedPassword = $this->passwordHasher->hashPassword(
            $admin,
            'admin123'
        );
        $admin->setPassword($hashedPassword);
        
        $manager->persist($admin);

        $manager->flush();
    }
}
