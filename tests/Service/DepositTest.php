<?php declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Money as Entity;
use App\Service\Money;
use App\Service\Deposit;

class DepositTest extends TestCase
{
    public function testCanGetBalanceAfterDeposit()
    {
        $amount = 100;
        $expected = 250;
        $entity = new Entity();
        $entity->setBalance(150);
        
        $transaction = new Deposit();
        $money = new Money();
        $money->transaction($entity, $transaction);        
        $result = $transaction->make($money, $amount);
        
        $this->assertEquals($expected, $result->getEntity()->getBalance());
    }
}
