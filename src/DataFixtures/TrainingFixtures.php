<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Training;

class TrainingFixtures extends Fixture
{
    public const TRAINING_REFERENCE_1 = 'training1';
    public const TRAINING_REFERENCE_2 = 'training2';

    public function load(ObjectManager $manager): void
    {
        $training1 = new Training();
        $training1->setDateAt(new \DateTime('now'));
        $manager->persist($training1);
        
        $training2 = new Training();
        $training2->setDateAt(new \DateTime('tomorrow'));
        $manager->persist($training2);
        
        $manager->flush();
        
        $this->addReference(self::TRAINING_REFERENCE_1, $training1);
        $this->addReference(self::TRAINING_REFERENCE_2, $training2);
    }
}
