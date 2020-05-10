<?php declare (strict_types=1);

namespace App\Service;

use App\Entity\Money as MoneyEntity;
use App\Service\TransactionInterface;

class Money
{
    public const TRANSACTION_DEPOSIT = 1;
    public const TRANSACTION_WITHDRAW = 2;
    
    private $entity;
    private $transaction;
    
    public function transaction(MoneyEntity $entity, TransactionInterface $transaction)
    {
        $this->entity = $entity;
        $this->transaction = $transaction;
    }
    
    public function getTransaction(): TransactionInterface
    {
        return $this->transaction;
    }
    
    public function getEntity(): MoneyEntity
    {
        return $this->entity;
    }
}
