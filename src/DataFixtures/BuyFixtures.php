<?php declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Buy;

class BuyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tomorrow = new \DateTime();
        $tomorrow->add(new \DateInterval("PT24H"));
        $tomorrow->format('Y-m-d');
        
        $buy = new Buy();
        $buy->setEndDay($tomorrow);
        $buy->setDescription('Buy 1');
        $buy->setCompleted(false);
        $manager->persist($buy);
        
        $buy = new Buy();
        $buy->setEndDay($tomorrow);
        $buy->setDescription('Buy 2');
        $buy->setCompleted(false);
        $manager->persist($buy);
        
        $manager->flush();
    }
}
