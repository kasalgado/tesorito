<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

use App\Entity\Money;
use App\Entity\User;

/**
 * @method Money|null find($id, $lockMode = null, $lockVersion = null)
 * @method Money|null findOneBy(array $criteria, array $orderBy = null)
 * @method Money[]    findAll()
 * @method Money[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MoneyRepository extends ServiceEntityRepository
{
    const MAX_RESULTS = 5;
    
    private $authChecker;
    private $security;
    
    public function __construct(
        ManagerRegistry $registry,
        AuthorizationCheckerInterface $authChecker,
        Security $security
    )
    {
        parent::__construct($registry, Money::class);
        $this->authChecker = $authChecker;
        $this->security = $security;
    }
    
    public function findByUserId(): array
    {
        if ($this->authChecker->isGranted('ROLE_ADMIN')) {
            return $this->findAll();
        }
        
        return $this->createQueryBuilder('m')
            ->andWhere('m.user = :user')
            ->setParameter('user', $this->security->getUser())
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(self::MAX_RESULTS)
            ->getQuery()
            ->getResult();
    }
}
