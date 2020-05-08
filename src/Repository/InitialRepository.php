<?php

namespace App\Repository;

use App\Entity\Initial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Initial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Initial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Initial[]    findAll()
 * @method Initial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InitialRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Initial::class);
    }

    // /**
    //  * @return Initial[] Returns an array of Initial objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Initial
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
