<?php declare (strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

use App\Entity\User;

/**
 * @Route("/api", name="_api")
 */
class AuthentificationController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/user")
     */
    public function verifyUserAction(Request $request, LoggerInterface $logger)
    {
        $logger->info('username: '.$request->get('username'));
        
        $content = json_decode($request->getContent());
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'name' => $content->username,
        ]);
        
        if ($user) {
            $view = $this->view('success');
        } else {
            $view = $this->view('failure');
        }

        return $this->handleView($view);
    }
}
