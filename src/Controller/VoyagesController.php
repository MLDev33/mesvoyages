<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of VoyagesController
 *
 * @author m-lordiportable
 */
class VoyagesController extends AbstractController {

    #[Route("/voyages", name: "voyages")]
    public function index(): Response {
        $visites = $this->repository->findAllOrderBy('datecreation', 'DESC');
        return $this->render("pages/voyages.html.twig", [
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

    #[Route("/voyages/tri/{champ}/{order}", name: "voyages.sort")]
    public function sort($champ, $order): Response {
        $visites = $this->repository->findAllOrderBy($champ, $order);
        return $this->render("pages/voyages.html.twig", [
                    'visites' => $visites
        ]);
    }
}
