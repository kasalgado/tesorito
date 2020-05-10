<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Entity\Task;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
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
        parent::__construct($registry, Task::class);        
        $this->authChecker = $authChecker;
        $this->session = $session;
        $this->params = $params;
    }
    
    public function findByDate(): array
    {
        $environment = $this->session->get($this->params->get('environment_name'));
        
        if ($this->authChecker->isGranted('ROLE_ADMIN') && $environment === $this->params->get('environment_admin')) {
            return $this->findAll();
        } else {        
            $today = new \DateTime('now');
            
            return $this->createQueryBuilder('t')
                ->andWhere('t.on_day = :today')
                ->setParameter('today', $today->format('Y-m-d'))
                ->getQuery()
                ->getResult();
        }
    }
}
