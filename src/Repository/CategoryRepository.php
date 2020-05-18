<?php

namespace App\Repository;

use App\Controller\SiteController;
use App\Entity\Category;
use App\Entity\Zone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function test($siteId)
    {
        $subquery = $this->getEntityManager()->getRepository(Zone::class)->createQueryBuilder('zone');
        $subquery->where('zone.site = ?1');

        $result = $this->createQueryBuilder('category')
            ->where($this->createQueryBuilder('category')->expr()->notIn('category.id', $subquery->getDQL()))
            ->setParameter('1', $siteId)
            ->orderBy('category.name', 'ASC')
        ;

        return $result;
    }

    /**
     * @return Query
     */
    public function categoryNotSelectedBySiteId($siteId)
    {
        // Sélection de toutes les catégories auxquelles on enleve ( NOT IN ) les catégories déjà présentes pour le chantier en cours d'édition
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT c FROM App\Entity\Category c WHERE c.Type = ?2 AND c.id NOT IN (SELECT zc.id FROM App\Entity\Zone z LEFT JOIN z.category zc WHERE z.site = ?1) ORDER BY c.name ASC');
        $query->setParameter(1, $siteId);
        $query->setParameter(2, SiteController::PHASE);

        return $query->getResult();
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
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
    public function findOneBySomeField($value): ?Category
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
