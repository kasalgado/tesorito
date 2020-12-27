<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Entity\Appointment;

/**
 * @method Appointment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Appointment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Appointment[]    findAll()
 * @method Appointment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AppointmentRepository extends ServiceEntityRepository
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
        parent::__construct($registry, Appointment::class);
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
            
            return $this->createQueryBuilder('a')
                ->andWhere('a.date_time > :today')
                ->setParameter('today', $today->format('Y-m-d'))
                ->orderBy('a.date_time', 'ASC')
                ->getQuery()
                ->getResult();
        }
    }
}
