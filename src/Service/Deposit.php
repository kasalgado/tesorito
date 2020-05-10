<?php declare (strict_types=1);

namespace App\Service;

use App\Service\Money;

class Deposit implements TransactionInterface
{
    public function make(Money $money, float $amount): Money
    {
        $money->getEntity()->setBalance($money->getEntity()->getBalance() + $amount);
        
        return $money;
    }
}
