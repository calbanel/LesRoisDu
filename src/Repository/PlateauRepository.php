<?php

namespace App\Repository;

use App\Entity\Plateau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Plateau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plateau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plateau[]    findAll()
 * @method Plateau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlateauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plateau::class);
    }

    /**
     * @return Plateau[] Returns an array of Plateau objects
     */
    public function findPlateauByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->join('p.utilisateurs','u')
            ->andWhere(':val = u.id')
            ->setParameter('val', $user)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
  

    /*
    public function findOneBySomeField($value): ?Plateau
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
