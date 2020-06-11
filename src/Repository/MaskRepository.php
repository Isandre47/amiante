<?php

namespace App\Repository;

use App\Entity\Mask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mask|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mask|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mask[]    findAll()
 * @method Mask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mask::class);
    }

    // /**
    //  * @return Mask[] Returns an array of Mask objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mask
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
