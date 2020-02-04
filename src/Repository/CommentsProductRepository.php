<?php

namespace App\Repository;

use App\Entity\CommentsProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommentsProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentsProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentsProduct[]    findAll()
 * @method CommentsProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentsProduct::class);
    }

    // /**
    //  * @return CommentsProduct[] Returns an array of CommentsProduct objects
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
    public function findOneBySomeField($value): ?CommentsProduct
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
