<?php

namespace App\Repository;

use App\Entity\Pion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Pion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pion[]    findAll()
 * @method Pion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pion::class);
    }

    // /**
    //  * @return Pion[] Returns an array of Pion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pion
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
