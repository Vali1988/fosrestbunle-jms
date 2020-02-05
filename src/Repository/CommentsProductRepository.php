<?php

namespace App\Repository;

use App\Entity\CommentsProduct;
use App\Repository\Traits\PaginationTrait;
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
	use PaginationTrait;
	protected $entity = CommentsProduct::class;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentsProduct::class);
    }
}
