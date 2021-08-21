<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class InstructorFixture extends BaseFixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'instructors', function($i) {
            $instructor = new User();
            $instructor->setEmail(sprintf('instructor%d@lesmills.com.au', $i));
            $instructor->setUsername($this->faker->userName);
            $instructor->setRoles(['ROLE_INSTRUCTOR']);
            $instructor->agreeTerms();

            $instructor->setPassword($this->passwordHasher->hashPassword(
                $instructor,
                'lesmills'
            ));

            return $instructor;
        });

        $manager->flush();
    }
}
