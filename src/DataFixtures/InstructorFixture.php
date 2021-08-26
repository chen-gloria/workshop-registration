<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class InstructorFixture extends BaseFixture implements DependentFixtureInterface
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

            $workshops = $this->getRandomReferences('workshops', $this->faker->numberBetween(0, 5));
            foreach ($workshops as $workshop) {
                $instructor->addWorkshop($workshop);
            }

            // return an instructor
            return $instructor;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            WorkshopFixture::class,
        ];
    }
}
