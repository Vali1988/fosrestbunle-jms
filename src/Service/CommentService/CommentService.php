<?php


namespace App\Service\CommentService;


use App\Entity\Comments;
use Doctrine\ORM\EntityManagerInterface;

class CommentService implements CommentServiceInterface
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	function add(Comments $comment)
	{
		$this->entityManager->getRepository(Comments::class)->add($comment);
	}
}