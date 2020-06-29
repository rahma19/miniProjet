<?php

namespace App\Repository;

use App\Entity\Circuit;
use App\Entity\Destination;
use App\Entity\EtapeCircuit;
use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;

/**
 * @method EtapeCircuit|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtapeCircuit|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtapeCircuit[]    findAll()
 * @method EtapeCircuit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtapeCircuitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtapeCircuit::class);
    }

    /**
     * @return EtapeCircuit[]
     */
    public function find_circuit_etape(){
        $res=$this->getEntityManager();
        $query=$res->createQuery(
            'SELECT DISTINCT v,e FROM App\Entity\EtapeCircuit v LEFT JOIN v.circuit_etape e');
        return $query->getResult();
    }

    public function find_circuit($id){
        $circ=$this->find_circuit_etape();
        foreach($circ as $c)
        { if ($c->getCircuitEtape()->getId()==$id)
        $res=$c;
        }
        return $res;
    }

    /**
     * @return Destination[]
     */
    public function findDest():array {
        $res= $this->createQueryBuilder('c');
        $res ->select('v')
            ->leftJoin('App\Entity\Ville','v','WITH','c.ville_etape=v.code_ville')
            ->where($res->expr()->isNull('c.ville_etape'));
        return $res->getQuery()->getResult();
    }

    public function modify(){
        $entityManager = $this->getEntityManager();
        $product = $entityManager->getRepository(EtapeCircuit::class)->findOneBy(array('ville_etape'=>'1'));
        $product->setDureeEtape(3);
        $entityManager->flush();

    }


    /**
     * @return EtapeCircuit[]
     */
    public function findOrdre():array {
        return $this->createQueryBuilder('c')
            ->where('c.ordre_etape=1')
            ->groupBy('c.ville_etape')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return EtapeCircuit[]
     */
    public function findDuree():array {
        return $this->createQueryBuilder('c')
            ->where('c.ville_etape=11')
            ->orderBy('c.ordre_etape','DESC')
            ->getQuery()
            ->getResult();
    }


    //$entityManager = $this->getEntityManager();
    /* return $entityManager->createQueryBuilder('c')
         ->leftJoin('','','with','')
         ->where('c.ordre_etape=1')
         ->orderBy('c.getVilleEtape', 'ASC')
         ->getQuery()
         ->getResult();*/


    // /**
    //  * @return EtapeCircuit[] Returns an array of EtapeCircuit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EtapeCircuit
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
