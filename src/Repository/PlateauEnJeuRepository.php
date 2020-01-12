<?php

namespace App\Repository;

use App\Entity\PlateauEnJeu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlateauEnJeu|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlateauEnJeu|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlateauEnJeu[]    findAll()
 * @method PlateauEnJeu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlateauEnJeuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlateauEnJeu::class);
    }

    // /**
    //  * @return PlateauEnJeu[] Returns an array of PlateauEnJeu objects
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
    public function findOneBySomeField($value): ?PlateauEnJeu
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
