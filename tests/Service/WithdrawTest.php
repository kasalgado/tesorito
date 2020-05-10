<?php declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Money as Entity;
use App\Service\Money;
use App\Service\Withdraw;

class WithdrawTest extends TestCase
{
    public function testCanNotWithdrawIfNotEnoughBalance()
    {
        $amount = 100;
        $entity = new Entity();
        $entity->setBalance(50);
        
        $transaction = new Withdraw();
        $money = new Money();
        $money->transaction($entity, $transaction);
        
        $this->expectExceptionMessage('Transaction is not posible. Not enough funds!');
        $transaction->make($money, $amount);
    }
    
    public function testCanGetBalanceAfterWithdraw()
    {
        $amount = 100;
        $expected = 50;
        $entity = new Entity();
        $entity->setBalance(150);
        
        $transaction = new Withdraw();
        $money = new Money();
        $money->transaction($entity, $transaction);        
        $result = $transaction->make($money, $amount);
        
        $this->assertEquals($expected, $result->getEntity()->getBalance());
    }
}
