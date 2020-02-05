<?php


namespace App\Service\CommentService;


use App\Entity\Comments;
use App\Service\CollectionService\CollectionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CommentService implements CommentServiceInterface
{
	private $entityManager;

	private $collectionService;

	public function __construct(EntityManagerInterface $entityManager, CollectionServiceInterface $collectionService)
	{
		$this->entityManager = $entityManager;
		$this->collectionService = $collectionService;
	}

	public function collection(Request $request)
	{
		return $this->collectionService->collection($request->query->get('entity'), $request);
	}

	function add(Comments $comment)
	{
		$this->entityManager->getRepository(Comments::class)->add($comment);
	}
}