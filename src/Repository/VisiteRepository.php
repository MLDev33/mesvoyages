<?php

namespace App\Repository;

use App\Entity\Visite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Visite>
 */
class VisiteRepository extends ServiceEntityRepository {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Visite::class);
    }

    /**
     * Retourne toutes les visites triées sur un champ
     * @param type $champ
     * @param type $order
     * @return Visite[]
     */
    public function findAllOrderBy($champ, $order): array {
        return $this->createQueryBuilder('v')
                        ->orderBy('v.' . $champ, $order)
                        ->getQuery()
                        ->getResult();
    }
    
    /**
     * Enregistrements dont un champ est égal à une valeur
     * ou tous les enregistrements si la valeur est vide
     * @param type $champ
     * @param type $valeur
     * @return Vistes[]
     */
    public function findByEqualValue($champ, $valeur): array {
        if ($valeur=="") {
            return $this->createQueryBuilder('v')
                            ->orderBy('v.'. $champ, 'ASC')
                            ->getQuery()
                            ->getResult();
        } else {
            return $this->createQueryBuilder('v')
                            ->where('v.'. $champ.'=:valeur')
                            ->setParameter('valeur', $valeur)
                            ->orderBy('v.datecreation', 'DESC')
                            ->getQuery()
                            ->getResult();
        }
    }
    
    /**
     * 
     * @param Visite $visite
     * @return void
     */
    public function remove(Visite $visite): void
    {
        $this->getEntityManager()->remove($visite);
        $this->getEntityManager()->flush();
    }
    
    /**
     * 
     * @param Visite $visite
     * @return void
     */
    public function add(Visite $visite): void
    {
        $this->getEntityManager()->persist($visite);
        $this->getEntityManager()->flush();
    }
}
