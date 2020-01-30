<?php


namespace App\Service\BrandService;


use App\Entity\Brand;
use App\Service\CollectionService\CollectionServiceInterface;
use App\Service\SerializerService\SerializerServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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

	public function getElement(string $slug, string $identifier = 'id')
	{
		$brand = $this->entityManager->getRepository(Brand::class)->findOneBy([$identifier => $slug]);

		if(!$brand) {
			throw new NotFoundHttpException('Brand Not Found');
		}

		return $brand;
	}

	function collection(Request $request)
	{
		return $this->collectionService->collection(Brand::class, $request);
	}

	function add(Brand $brand)
	{
		$this->checkRights(['method' => Request::METHOD_POST]);
		$this->entityManager->getRepository(Brand::class)->add($brand);
	}

	function update(Brand $brand)
	{
		$this->checkRights(['method' => Request::METHOD_PATCH]);
		$this->entityManager->getRepository(Brand::class)->add($brand);
	}

	function delete(string $slug, string $identifier = 'id')
	{
		$tag = $this->getElement($slug, $identifier);
		$this->checkRights(['method' => Request::METHOD_DELETE]);
		$this->entityManager->getRepository(Brand::class)->delete($tag);
	}

	public function item(string $slug, string $identifier = 'id')
	{
		return $this->getElement($slug, $identifier);
	}
}