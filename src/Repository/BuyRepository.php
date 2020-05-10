<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Entity\Buy;

/**
 * @method Buy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Buy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Buy[]    findAll()
 * @method Buy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuyRepository extends ServiceEntityRepository
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
        parent::__construct($registry, Buy::class);
        $this->authChecker = $authChecker;
        $this->session = $session;
        $this->params = $params;
    }
    
    public function findByEndDay(): array
    {
        $today = new \DateTime('now');
        $environment = $this->session->get($this->params->get('environment_name'));
        
        if ($this->authChecker->isGranted('ROLE_ADMIN') && $environment === $this->params->get('environment_admin')) {
            return $this->findAll();
        }
        
        return $this->createQueryBuilder('b')
            ->andWhere('b.end_day >= :today')
            ->setParameter('today', $today->format('Y-m-d'))
            ->getQuery()
            ->getResult();
    }
}
