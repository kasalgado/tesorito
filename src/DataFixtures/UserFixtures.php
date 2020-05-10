<?php declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;

class UserFixtures extends Fixture
{
    public const USER_REFERENCE = 'user';
    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail('test@test.de');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, 'test1234'));
        $user1->setName('Nikel');
        $manager->persist($user1);
        
        $user2 = new User();
        $user2->setEmail('admin@test.de');
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setPassword($this->passwordEncoder->encodePassword($user2, 'test1234'));
        $user2->setName('KAS');
        $manager->persist($user2);
        
        $manager->flush();
        
        $this->addReference(self::USER_REFERENCE, $user1);
    }
}
