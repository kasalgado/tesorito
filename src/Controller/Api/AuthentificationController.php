<?php declare (strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;

/**
 * @Route("/api", name="_api")
 */
class AuthentificationController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/user")
     */
    public function verifyUserAction(
            Request $request,
            LoggerInterface $logger,
            UserPasswordEncoderInterface $passwordEncoder
    )
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'email' => $request->request->get('email'),
        ]);
        
        if ($user && $passwordEncoder->isPasswordValid($user, $request->request->get('password'))) {
            $view = $this->view(Response::HTTP_OK, Response::HTTP_OK);
            $logger->info('user found'.$user->getId());
        } else {
            $view = $this->view(Response::HTTP_NOT_FOUND, Response::HTTP_NOT_FOUND);
            $logger->info('user not found');
        }

        return $this->handleView($view);
    }
}
