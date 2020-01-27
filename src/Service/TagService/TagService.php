<?php


namespace App\Service\TagService;


use App\Entity\Tag;
use App\Service\CollectionService\CollectionServiceInterface;
use App\Service\SerializerService\SerializerServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TagService implements TagServiceInterface
{
	/**
	 * @var EntityManagerInterface
	 */
	private $entityManager;
	/**
	 * @var CollectionServiceInterface
	 */
	private $collectionService;
	/**
	 * @var AuthorizationCheckerInterface
	 */
	private $authorizationChecker;

	public function __construct(EntityManagerInterface $entityManager,
								CollectionServiceInterface $collectionService,
								AuthorizationCheckerInterface $authorizationChecker)
	{
		$this->entityManager = $entityManager;
		$this->collectionService = $collectionService;
		$this->authorizationChecker = $authorizationChecker;
	}
	function checkRights(array $parameters)
	{

		if(in_array($parameters['method'], [Request::METHOD_POST, Request::METHOD_PATCH, Request::METHOD_DELETE])
			&& !$this->authorizationChecker->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
	}

	function collection(Request $request)
	{
		return $this->collectionService->collection(Tag::class, $request);
	}

	function add(Tag $tag)
	{
		$this->checkRights(['method' => Request::METHOD_POST]);
		$this->entityManager->getRepository(Tag::class)->add($tag);
		return $tag;
	}

	function update(Tag $tag)
	{
		$this->checkRights(['method' => Request::METHOD_PATCH]);
		$this->entityManager->getRepository(Tag::class)->add($tag);
		return $tag;
	}

	function delete(Tag $tag)
	{
		$this->checkRights(['method' => Request::METHOD_DELETE]);
		$this->entityManager->getRepository(Tag::class)->delete($tag);
	}

	function item(Tag $tag)
	{
		return $tag;
	}
}