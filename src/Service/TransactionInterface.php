<?php declare (strict_types=1);

namespace App\Service;

use App\Service\Money;

interface TransactionInterface
{
    public function make(Money $money, float $amount);
}
