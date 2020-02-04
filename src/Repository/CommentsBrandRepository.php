<?php

namespace App\Repository;

use App\Entity\CommentsBrand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommentsBrand|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentsBrand|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentsBrand[]    findAll()
 * @method CommentsBrand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsBrandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentsBrand::class);
    }

    // /**
    //  * @return CommentsBrand[] Returns an array of CommentsBrand objects
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
    public function findOneBySomeField($value): ?CommentsBrand
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
