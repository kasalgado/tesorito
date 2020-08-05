<?php declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

use App\Service\Money;
use App\Entity\Money as MoneyEntity;

class MoneyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $money = new MoneyEntity();
        $money->setUser($this->getReference(UserFixtures::USER_REFERENCE));
        $money->setTransType(Money::TRANSACTION_DEPOSIT);
        $money->setAmount(0);
        $money->setBalance(0);
        $money->setDescription('initial amount');
        $manager->persist($money);
        
        $money = new MoneyEntity();
        $money->setUser($this->getReference(UserFixtures::USER_REFERENCE));
        $money->setTransType(Money::TRANSACTION_DEPOSIT);
        $money->setAmount(100);
        $money->setBalance(100);
        $money->setDescription(null);
        $manager->persist($money);
        
        $money = new MoneyEntity();
        $money->setUser($this->getReference(UserFixtures::USER_REFERENCE));
        $money->setTransType(Money::TRANSACTION_WITHDRAW);
        $money->setAmount(50);
        $money->setBalance(50);
        $money->setDescription('buy something');
        $manager->persist($money);
        
        $manager->flush();
    }
    
    public function getDependencies()
    {
        return [UserFixtures::class];
    }
}
