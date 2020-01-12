<?php

namespace App\Repository;

use App\Entity\Createur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Createur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Createur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Createur[]    findAll()
 * @method Createur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Createur::class);
    }

    // /**
    //  * @return Createur[] Returns an array of Createur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Createur
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
