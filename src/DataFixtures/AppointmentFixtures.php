<?php declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Appointment;

class AppointmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $datetime = new \DateTime();
        $datetime->add(new \DateInterval("PT1H"));
        $datetime->format('Y-m-d H:i:s');
        
        $appointment = new Appointment();
        $appointment->setDateTime($datetime);
        $appointment->setDescription('Appointment 1');
        $appointment->setWeekly(false);
        $manager->persist($appointment);
        
        $datetime->add(new \DateInterval("PT2H"));
        $appointment = new Appointment();
        $appointment->setDateTime($datetime);
        $appointment->setDescription('Appointment 2');
        $appointment->setWeekly(true);
        $manager->persist($appointment);
        
        $manager->flush();
    }
}
