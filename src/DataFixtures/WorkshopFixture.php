<?php

namespace App\DataFixtures;

use App\Entity\Workshop;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class WorkshopFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(50, 'workshops', function($count) use ($manager) {
            $workshop = new Workshop();
            $workshop->setName($this->faker->name);
            $workshop->setLocation($this->faker->address);
            $workshop->setStartsAt($this->faker->dateTimeBetween('now', '+3 months'));
            $workshop->setEndsAt($this->faker->dateTimeBetween($workshop->getStartsAt(), '+3 months'));
            $workshop->setCapacity($this->faker->numberBetween(10, 100));

            $workshop->setProgram($this->getRandomReference('programs'));

            return $workshop;
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixture::class];
    }
}
