<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Homework;
use App\Service\Observer;
use App\Service\DataCache;

class HomeworkController extends AbstractController
{
    const HOMEWORK_STATUS_COMPLETED = 'completed';
    
    /**
     * @Route("/homework/update/{status}", name="_homework_update", requirements={"status"="\w+"})
     * @Template("/homework/default.html.twig")
     */
    public function update(string $status, Observer $observer, EntityManagerInterface $em): array
    {
        if ($status === self::HOMEWORK_STATUS_COMPLETED) {
            $homework = $this->getDoctrine()->getRepository(Homework::class)->findOneBy([
                'on_day' => new \DateTime('now')
            ]);
            $homework->setStatus($status);
        } else {
            $homework = new Homework();
            $homework->setStatus($status);
        }

        $em->persist($homework);
        $em->flush();

        $observer->update('homework');
        
        return ['homework' => $homework];
    }
    
    /**
     * @Route("/homework/list", name="_homework_list", methods={"POST"})
     * @Template("/homework/default.html.twig")
     */
    public function list(DataCache $cache): array
    {
        $homework = $this->getDoctrine()->getRepository(Homework::class)->findBy([
            'on_day' => new \Datetime('now'),
        ]);
        
        return [
            'homework' => $cache->get($homework, 'homework'),
        ];
    }
}
