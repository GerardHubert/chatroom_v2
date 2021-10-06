<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;

class AppFixtures extends Fixture
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        // Données aléatoires
        $faker = \Faker\Factory::create('fr_FR');

        // Administrateur fictif
        $admin = new User;
        $admin->setUsername(strtolower($this->slugger->slug($faker->firstName())))
            ->setPassword(password_hash('password', PASSWORD_ARGON2I))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        // quelques utilisateurs fictifs
        for ($i = 0; $i < 20; $i++) {
            $user = new User;
            $user->setUsername(strtolower($this->slugger->slug($faker->firstName() . '_' . $faker->lastName())))
                ->setPassword(password_hash('password', PASSWORD_ARGON2I))
                ->setRoles(['ROLE_USER']);
            $manager->persist($user);
        }

        $manager->flush();
    }
}
