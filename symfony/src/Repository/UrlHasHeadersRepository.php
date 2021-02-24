<?php

namespace App\Repository;

use App\Entity\UrlHasHeaders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UrlHasHeaders|null find($id, $lockMode = null, $lockVersion = null)
 * @method UrlHasHeaders|null findOneBy(array $criteria, array $orderBy = null)
 * @method UrlHasHeaders[]    findAll()
 * @method UrlHasHeaders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UrlHasHeadersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UrlHasHeaders::class);
    }

    // /**
    //  * @return UrlHasHeaders[] Returns an array of UrlHasHeaders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UrlHasHeaders
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
