<?php declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Task;

class TaskFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $now = new \DateTime('now');
        $task = new Task();
        $task->setOnDay($now);
        $task->setDescription('Task 1');
        $task->setCompleted(false);
        $manager->persist($task);
        
        $task = new Task();
        $task->setOnDay($now);
        $task->setDescription('Task 2');
        $task->setCompleted(false);
        $manager->persist($task);
        
        $manager->flush();
    }
}
