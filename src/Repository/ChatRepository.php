<?php

namespace App\Repository;

use App\Entity\Chat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

use App\Entity\User;

/**
 * @method Chat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chat[]    findAll()
 * @method Chat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatRepository extends ServiceEntityRepository
{
    private $today;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
        
        $today = new \DateTime('now');
        $this->today = $today->format('Y-m-d');
    }
    
    public function findByDateTime(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.date_time >= :today')
            ->setParameter('today', $this->today)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByUser(User $user, bool $new): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user != :user')
            ->andWhere('c.new_message = :new')
            ->andWhere('c.date_time >= :today')
            ->setParameters([
                'user' => $user,
                'new' => $new,
                'today' => $this->today,
            ])
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findByMonitor(bool $status): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.monitor = :status')
            ->andWhere('c.date_time >= :today')
            ->setParameters([
                'status' => $status,
                'today' => $this->today,
            ])
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
