<?php


namespace App\Service\ProductService;


use App\Entity\Product;
use App\Service\CollectionService\CollectionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class ProductService implements ProductServiceInterface
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
		if(in_array($parameters['method'], [Request::METHOD_POST, Request::METHOD_PATCH, Request::METHOD_DELETE])
			&& !$this->authorizationChecker->isGranted('ROLE_ADMIN'))
		{
			throw new AccessDeniedException();
		}
	}

	public function getElement(string $slug, string $identifier = 'id')
	{
		$brand = $this->entityManager->getRepository(Product::class)->findOneBy([$identifier => $slug]);

		if(!$brand) {
			throw new NotFoundHttpException('Product Not Found');
		}

		return $brand;
	}

	function collection(Request $request)
	{
		return $this->collectionService->collection(Product::class, $request);
	}

	function add(Product $brand)
	{
		$this->checkRights(['method' => Request::METHOD_POST]);
		$this->entityManager->getRepository(Product::class)->add($brand);
	}

	function update(Product $brand)
	{
		$this->checkRights(['method' => Request::METHOD_PATCH]);
		$this->entityManager->getRepository(Product::class)->add($brand);
	}

	function delete(string $slug, string $identifier = 'id')
	{
		$tag = $this->getElement($slug, $identifier);
		$this->checkRights(['method' => Request::METHOD_DELETE]);
		$this->entityManager->getRepository(Product::class)->delete($tag);
	}

	public function item(string $slug, string $identifier = 'id')
	{
		return $this->getElement($slug, $identifier);
	}
}