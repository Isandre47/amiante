<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 22/05/2020 20:06
 *
 */

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

     /**
      * @return Query Returns an array of User objects
      */
    public function allUsers(): Query
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
        ;
    }

     /**
      * @return Query Returns an array of User objects
      */
    public function allUsersWithSites(): Query
    {
        return $this->createQueryBuilder('u')
            ->leftJoin('u.site', 'site')
            ->addSelect('site')
            ->orderBy('u.id', 'ASC')
            ->getQuery()
        ;
    }

    public function userInfo($userId)
    {
        return $this->createQueryBuilder('u')
            ->where('u.id = ?1')
            ->addSelect('site')
            ->addSelect('zones')
            ->addSelect('category')
            ->addSelect('removals')
            ->addSelect('outputs')
            ->innerJoin('u.site', 'site')
            ->innerJoin('site.zones', 'zones')
            ->innerJoin('zones.category', 'category')
            ->innerJoin('zones.initials', 'initials')
            ->innerJoin('zones.removals', 'removals')
            ->innerJoin('zones.outputs', 'outputs')
            ->setParameter('1', $userId)
            ->getQuery()->getResult();
    }
    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
