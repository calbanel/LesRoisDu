<?php

namespace App\Repository;

use App\Entity\Partie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Partie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partie[]    findAll()
 * @method Partie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partie::class);
    }

    /**
     * @return Partie[] Returns an array of Partie objects
    */

    public function findPartieByCreateur($user)
    {
        return $this->createQueryBuilder('p')
            ->join('p.createur','u')
            ->andWhere(':val = u.id')
            ->setParameter('val', $user)
            ->orderBy('p.derniereModification', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @return Partie[] Returns an array of Partie objects
    */

    public function findPartieByJoueur($user)
    {
        return $this->createQueryBuilder('p')
            ->join('p.joueurs','u')
            ->andWhere(':val = u.id')
            ->setParameter('val', $user)
            ->orderBy('p.dateRejoins', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Partie
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
