<?php

namespace App\DataFixtures;

use App\Entity\TrainingTask;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrainingTaskFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $time = new \DateTime('00:30:00');
        $time->format('H:i:s');

        $task1 = new TrainingTask();
        $task1->setName('Training task 1');
        $task1->setDescription('Description of the training task 1');
        $task1->setDuration($time);
        $task1->setTraining($this->getReference(TrainingFixtures::TRAINING_REFERENCE_1));
        $task1->setCompleted(false);
        $manager->persist($task1);

        $task2 = new TrainingTask();
        $task2->setName('Training task 2');
        $task2->setDescription('Description of the training task 2');
        $task2->setDuration($time);
        $task2->setTraining($this->getReference(TrainingFixtures::TRAINING_REFERENCE_1));
        $task2->setCompleted(false);
        $manager->persist($task2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [TrainingFixtures::class];
    }
}
