<?php declare (strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

/**
 * Class MoneyController
 * @Route("/api", name="_api")
 */
class AuthentificationController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/user")
     */
    public function getUser(Request $request): Response
    {
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
