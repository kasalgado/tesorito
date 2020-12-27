<?php

namespace App\Repository;

use App\Entity\MealDish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MealDish|null find($id, $lockMode = null, $lockVersion = null)
 * @method MealDish|null findOneBy(array $criteria, array $orderBy = null)
 * @method MealDish[]    findAll()
 * @method MealDish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealDishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MealDish::class);
    }

    // /**
    //  * @return MealDish[] Returns an array of MealDish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MealDish
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
