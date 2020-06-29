<?php

namespace App\Repository;

use App\Entity\Ville;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use http\QueryString;

/**
 * @method Ville|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ville|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ville[]    findAll()
 * @method Ville[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ville::class);
    }

    /**
     * @return Ville[]
     */
    public function find_ville_etape(){
        $res=$this->getEntityManager();
        $query=$res->createQuery(
            'SELECT DISTINCT v,e FROM App\Entity\Ville v LEFT JOIN v.etapeCircuits e');
        return $query->getResult();
    }

    public function RemoveVille() {
        $entityManager = $this->getEntityManager();
        //$res=$this->
        // $entityManager->remove($res);
        $entityManager->flush();
    }

    public function Remove() {
        $entityManager = $this->getEntityManager();
        $sub = $this->createQueryBuilder('v');
        $res= $this->createQueryBuilder('c')
            ->select('c.ville_etape')
            ->leftJoin('App\Entity\EtapeCircuit','c','WITH','c.ville_etape=v.code_ville');
        $res->andWhere($res->expr()->not($res->expr()->exists($sub->getDQL())));
        $entityManager->remove($res);
        $entityManager->flush();
    }

    // /**
    //  * @return Ville[] Returns an array of Ville objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ville
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
