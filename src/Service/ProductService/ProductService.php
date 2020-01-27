<?php


namespace App\Service\ProductService;


use App\Entity\Product;
use App\Service\CollectionService\CollectionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

	function collection(Request $request)
	{
		return $this->collectionService->collection(Product::class, $request);
	}

	function add(Product $product)
	{
		$this->checkRights(['method' => Request::METHOD_POST]);
		$this->entityManager->getRepository(Product::class)->add($product);
		return $product;
	}

	function update(Product $product)
	{
		$this->checkRights(['method' => Request::METHOD_PATCH]);
		$this->entityManager->getRepository(Product::class)->add($product);
		return $product;
	}

	function delete(Product $product)
	{
		$this->checkRights(['method' => Request::METHOD_DELETE]);
		$this->entityManager->getRepository(Product::class)->delete($product);
	}

	function item(Product $product)
	{
		$product->setVisit($product->getVisit() + 1);
		$this->entityManager->getRepository(Product::class)->add($product);
		return $product;
	}
}