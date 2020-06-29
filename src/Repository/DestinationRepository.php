<?php

namespace App\Repository;

use App\Entity\Destination;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Destination|null find($id, $lockMode = null, $lockVersion = null)
 * @method Destination|null findOneBy(array $criteria, array $orderBy = null)
 * @method Destination[]    findAll()
 * @method Destination[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DestinationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Destination::class);
    }

    /**
     * @return Destination[]
     */
    public function find_Ville_Dest(){
        $res=$this->getEntityManager();
        $query=$res->createQuery(
            'SELECT v,e FROM App\Entity\Destination v LEFT JOIN v.villes e ');
        return $query->getResult();
    }

    public function RemoveDest() {
        $entityManager = $this->getEntityManager();
        $res=$this->find_Ville_Dest();
        foreach($res as $valeur) {
            if ($valeur->getVilles()->count() == 0)
                $entityManager->remove($valeur);
            $entityManager->flush();
        }
    }

    // /**
    //  * @return Destination[] Returns an array of Destination objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Destination
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
