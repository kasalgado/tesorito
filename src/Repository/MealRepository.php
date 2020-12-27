<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Entity\Meal;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    private $authChecker;
    private $session;
    private $params;
    
    public function __construct(
        ManagerRegistry $registry,
        AuthorizationCheckerInterface $authChecker,
        SessionInterface $session,
        ParameterBagInterface $params
    )
    {
        parent::__construct($registry, Meal::class);
        $this->authChecker = $authChecker;
        $this->session = $session;
        $this->params = $params;
    }
    
    public function findByWeek(int $week): array
    {
        $environment = $this->session->get($this->params->get('environment_name'));
        
        if ($this->authChecker->isGranted('ROLE_ADMIN') && $environment === $this->params->get('environment_admin')) {
            return $this->findBy([], ['week' => 'ASC']);
        } else {
            return $this->findBy(['week' => $week]);
        }
    }
    
    public function findBackWeek(int $week): array
    {
        return $this->findBy(['week' => $week - 1]);
    }
    
    public function findNextWeek(int $week): array
    {
        return $this->findBy(['week' => $week + 1]);
    }
}
