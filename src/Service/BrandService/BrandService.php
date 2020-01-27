<?php


namespace App\Service\BrandService;


use App\Entity\Brand;
use App\Service\CollectionService\CollectionServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class BrandService implements BrandServiceInterface
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
		return
			$this->collectionService->collection(Brand::class, $request);
	}

	function add(Brand $brand)
	{
		$this->checkRights(['method' => Request::METHOD_POST]);
		$this->entityManager->getRepository(Brand::class)->add($brand);
		return $brand;
	}

	function update(Brand $brand)
	{
		$this->checkRights(['method' => Request::METHOD_PATCH]);
		$this->entityManager->getRepository(Brand::class)->add($brand);
		return $brand;
	}

	function delete(Brand $brand)
	{
		$this->checkRights(['method' => Request::METHOD_DELETE]);
		$this->entityManager->getRepository(Brand::class)->delete($brand);
	}

	public function item(Brand $brand)
	{
		return $brand;
	}
}