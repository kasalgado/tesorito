<?php declare (strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Security;

use App\Entity\Observer as ObserverEntity;
use App\Entity\User;

class Observer
{
    private $doctrine;
    private $security;
    
    public function __construct(ContainerInterface $container, Security $security)
    {
        $this->doctrine = $container->get('doctrine');
        $this->security = $security;
    }
    
    public function update(string $name): void
    {
        $repository = $this->doctrine->getRepository(ObserverEntity::class);
        $em = $this->doctrine->getManager();
        
        foreach ($this->doctrine->getRepository(User::class)->findOtherUsers() as $otherUser) {
            $observer = $repository->findOneBy(['widget' => $name, 'to_user' => $otherUser->getId()]);
            
            if ($observer) {
                $observer->setChanged(true);
            } else {
                $observer = new ObserverEntity();
                $observer->setFromUser($this->security->getUser());
                $observer->setToUser($otherUser);
                $observer->setLastChange(new \DateTime('now'));
                $observer->setWidget($name);
                $observer->setChanged(true);
            }
            
            $em->persist($observer);
        }
        
        $em->flush();
    }
}
