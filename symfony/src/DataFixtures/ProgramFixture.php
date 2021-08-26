<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixture extends BaseFixture
{
    private static $programNames = [
        'bodyattack',
        'bodybalance',
        'bodycombat',
        'bodyjam',
        'bodypump',
        'bodystep',
        'rpm',
        'shbam',
        'the_trip'
    ];

    private static $programImages = [
        'BODYATTACK.png',
        'BODYBALANCE.png',
        'BODYCOMBAT.png',
        'BODYJAM.png',
        'BODYPUMP.png',
        'BODYSTEP.png',
        'RPM.png',
        'SHBAM.png',
        'THETRIP.png'
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(9, 'programs', function($count) use ($manager) {
            $program = new Program();
            $program->setName(self::$programNames[$count]);
            $program->setImageFilename(self::$programImages[$count]);

            // Get the number of Instructors
            // $instructors = $this->getRandomReferences('instructors', $this->faker->numberBetween(0, 10));
            // foreach ($instructors as $instructor) {
            //     $program->addInstructor($instructor);
            // }

            return $program;
        });
        $manager->flush();
    }

    // public function getDependencies()
    // {
    //     return [
    //         InstructorFixture::class,
    //     ];
    // }
}
