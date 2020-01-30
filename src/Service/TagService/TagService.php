<?php


namespace App\Service\TagService;


use App\Entity\Tag;
use App\Service\CollectionService\CollectionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

	public function checkRights(array $parameters)
	{
		if(in_array($parameters['method'], [Request::METHOD_PATCH, Request::METHOD_PUT, Request::METHOD_POST, Request::METHOD_DELETE]) &&
			!$this->authorizationChecker->isGranted('ROLE_ADMIN')
		)
		{
			throw new AccessDeniedHttpException('Access Denied');
		}
	}

	public function getElement(string $slug, string $identifier = 'id')
	{
		$tag = $this->entityManager->getRepository(Tag::class)->findOneBy([$identifier => $slug]);

		if(!$tag) {
			throw new NotFoundHttpException('Tag Not Found');
		}

		return $tag;
	}

	public function collection(Request $request)
	{
		return $this->collectionService->collection(Tag::class, $request);
	}

	public function item(string $slug, string $identifier = 'id')
	{
		return $this->getElement($slug, $identifier);
	}

	function add(Tag $tag)
	{
		$this->checkRights(['method' => Request::METHOD_POST]);
		$this->entityManager->getRepository(Tag::class)->add($tag);
	}

	function delete(string $slug, string $identifier = 'id')
	{
		$tag = $this->getElement($slug, $identifier);
		$this->checkRights(['method' => Request::METHOD_DELETE]);
		$this->entityManager->getRepository(Tag::class)->delete($tag);
	}

	function update(Tag $tag, string $method = Request::METHOD_PATCH)
	{
		$this->checkRights(['method' => $method]);
		$this->entityManager->getRepository(Tag::class)->add($tag);
	}
}