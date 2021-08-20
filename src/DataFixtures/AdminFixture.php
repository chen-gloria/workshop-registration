<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixture extends BaseFixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    // Load Admin Data
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(5, 'admin', function($i) {
            $admin = new User();
            $admin->setEmail(sprintf('admin%d@lesmills.com.au', $i));
            $admin->setUsername($this->faker->userName);
            $admin->setRoles(['ROLE_ADMIN']);
            $admin->agreeTerms();
            
            $admin->setPassword($this->passwordHasher->hashPassword(
                $admin,
                'lesmills'
            ));
            // $admin->setPassword('lesmills');
            return $admin;
        });

        $manager->flush();
    }
}
