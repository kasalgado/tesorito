<?php declare (strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Entity\Money as Entity;
use App\Service\Money;
use App\Service\Withdraw;
use App\Service\Deposit;

class MoneyTest extends TestCase
{
    public function testCanNotWithdrawIfNotEnoughBalance()
    {
        $amount = 100;
        $entity = new Entity();
        $entity->setBalance(50);
        
        $this->expectExceptionMessage('Transaction is not posible. Not enough funds!');
        $transaction = new Withdraw();
        $money = new Money();
        $money->transaction($entity, $transaction);
        $money->getTransaction()->make($money, $amount);
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
        $money->getTransaction()->make($money, $amount);
        $balance = $money->getEntity();
        
        $this->assertEquals($expected, $balance->getBalance());
    }
    
    public function testCanGetBalanceAfterDeposit()
    {
        $amount = 150.25;
        $expected = 250.25;
        $entity = new Entity();
        $entity->setBalance(100);
        
        $transaction = new Deposit();
        $money = new Money();
        $money->transaction($entity, $transaction);
        $money->getTransaction()->make($money, $amount);
        $balance = $money->getEntity();
        
        $this->assertEquals($expected, $balance->getBalance());
    }
}
