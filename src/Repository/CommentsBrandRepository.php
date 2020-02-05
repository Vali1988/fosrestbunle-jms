<?php

namespace App\Repository;

use App\Entity\CommentsBrand;
use App\Repository\Traits\PaginationTrait;
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
	use PaginationTrait;
	protected $entity = CommentsBrand::class;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentsBrand::class);
    }
}
