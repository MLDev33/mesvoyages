<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * 
     * @param type $champ
     * @param type $order
     * @return Response
     */
    #[Route("/voyages/tri/{champ}/{order}", name: "voyages.sort")]
    public function sort($champ, $order): Response {
        $visites = $this->repository->findAllOrderBy($champ, $order);
        return $this->render("pages/voyages.html.twig", [
                    'visites' => $visites
        ]);
    }

    /**
     * 
     * @param type $champ
     * @param Request $request
     * @return Response
     */
    #[Route("/voyages/recherche/{champ}", name: "voyages.findallequal")]
    public function findAllEqual($champ, Request $request): Response {
        if ($this->isCsrfTokenValid('filtre_' . $champ, $request->get('_token'))) {
            $valeur = $request->get("recherche");
            $visites = $this->repository->findByEqualValue($champ, $valeur);
            return $this->render("pages/voyages.html.twig", [
                        'visites' => $visites
            ]);
        }
        return $this->redirectToRoute("voyages");
    }

    #[Route("/voyage/voyage/{id}", name: "voyages.showone")]
    public function showone($id): Response {
        $visite = $this->repository->find($id);
        return $this->render("pages/voyage.html.twig", [
                    'visite' => $visite
        ]);
    }
}
