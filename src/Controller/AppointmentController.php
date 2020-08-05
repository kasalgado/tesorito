<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Service\DataCache;
use App\Service\Observer;
use App\Utils\WeekDays;
use App\Repository\AppointmentRepository;

class AppointmentController extends AbstractController
{
    /**
     * @Route("/appointment/create", name="_appointment_create")
     * @Route("/appointment/edit", name="_appointment_edit")
     * @Template()
     */
    public function create(Request $request, Observer $observer, EntityManagerInterface $em)
    {
        $id = $request->get('id');
        $appointment = $id ? $this->repository()->find($id) : new Appointment();
        
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($appointment);
            $em->flush();
            
            $observer->update('appointment');
            
            if ($request->request->get('new_appointment') === '1') {
                return $this->redirect($this->generateUrl('_appointment_create'));
            }
            
            return $this->redirect($this->generateUrl('_admin_panel'));
        }
        
        return [
            'form' => $form->createView(),
            'id' => $id,
        ];
    }
    
    /**
     * @Route("/appointment/delete/{id}", name="_appointment_delete", requirements={"id"="\d+"})
     */
    public function delete(int $id, Observer $observer, EntityManagerInterface $em)
    {
        $appointment = $this->repository()->find($id);
        $em->remove($appointment);
        $em->flush();
        
        $observer->update('appointment');
        
        return $this->redirect($this->generateUrl('_admin_panel'));
    }
    
    /**
     * @Route("/appointment/list", name="_appointment_list", methods={"POST"})
     * @Template("/appointment/default.html.twig")
     */
    public function list(WeekDays $days, DataCache $cache): array
    {
        $appointments = $this->repository()->findByDate();
        
        return [
            'appointments' => $cache->get($appointments, 'appointment'),
            'days' => $days->get(),
        ];
    }

    /**
     * @Route("/appointment/today", name="_appointment_today")
     */
    public function setToday(Request $request, Observer $observer, EntityManagerInterface $em)
    {
        $appointment = $this->repository()->find($request->get('id'));
        $time = $appointment->getDateTime();
        $appointment->setDateTime(new \DateTime('now ' . $time->format('H:i:s')));
        $em->persist($appointment);
        $em->flush();

        $observer->update('appointment');

        return $this->redirect($this->generateUrl('_admin_panel'));
    }
    
    private function repository(): AppointmentRepository
    {
        return $this->getDoctrine()->getRepository(Appointment::class);
    }
}
