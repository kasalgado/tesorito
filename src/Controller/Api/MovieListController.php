<?php declare (strict_types=1);

namespace App\Controller\Api;

use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Route("/api", name="_api")
 */
class MovieListController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/movies")
     */
    public function getListAction()
    {
        $rootDir = $this->getParameter('kernel.project_dir');
        $view = $this->view(file_get_contents($rootDir.'/data/movies'));
        
        return $this->handleView($view);
    }
}
