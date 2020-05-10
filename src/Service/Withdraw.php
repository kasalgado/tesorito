<?php declare (strict_types=1);

namespace App\Service;

use App\Service\Money;

class Withdraw implements TransactionInterface
{
    public function make(Money $money, float $amount): Money
    {
        if ($money->getEntity()->getBalance() < $amount) {
            throw new \Exception('Transaction is not posible. Not enough funds!');
        }
        
        $money->getEntity()->setBalance($money->getEntity()->getBalance() - $amount);
        
        return $money;
    }
}
