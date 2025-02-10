<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccueilController
 *
 * @author m-lordiportable
 */
class AccueilController extends AbstractController {
    
    #[Route("/", name: "accueil")]
    public function index(): Response{
        $visites = $this->repository->findAllOrderByLastVisite();
        return $this->render("pages/accueil.html.twig", [
                    'visites' => $visites
        ]);
        
    }
    
      /**
     * 
     * @var VisiteRepository
     */
    private $repository;

    /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository) {
        $this->repository = $repository;
    }
}
