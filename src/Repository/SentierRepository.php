<?php

namespace App\Repository;

use App\Entity\Sentier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sentier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sentier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sentier[]    findAll()
 * @method Sentier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SentierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sentier::class);
    }

    // /**
    //  * @return Sentier[] Returns an array of Sentier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sentier
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
