<?php

namespace App\Repository;

use App\Entity\PlateauEnJei;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlateauEnJei|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlateauEnJei|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlateauEnJei[]    findAll()
 * @method PlateauEnJei[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlateauEnJeiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlateauEnJei::class);
    }

    // /**
    //  * @return PlateauEnJei[] Returns an array of PlateauEnJei objects
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
    public function findOneBySomeField($value): ?PlateauEnJei
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
