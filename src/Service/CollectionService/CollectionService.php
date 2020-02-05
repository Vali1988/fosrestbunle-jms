<?php


namespace App\Service\CollectionService;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CollectionService implements CollectionServiceInterface
{
	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function collection(string $entityClass, Request $request)
	{
		$repo = $this->entityManager->getRepository($entityClass);
		$count = $repo->countTotal($request->query->get('filter', []), $request->query->get('search', []));
		$result = $repo->findResult(
			$request->query->get('filter', []),
			$request->query->get('search', []),
			$request->query->get('pagination', [0,25]),
			$request->query->get('order', ['id', 'DESC'])
		);

		return ['count' => $count, 'result' => $result];
	}

	public function collectionRelation(Request $request, $entity, string $entityFunction)
	{
		$result = [];

		for($x = $request->query->get('initialPosition', 0); $x < $request->query->get('finalPosition', 24); $x++)
		{
			$result[] = $entity->$entityFunction()->get($x);
		}

		return [
			'total' => $entity->$entityFunction()->count(),
			'result' => $result,
		];
	}
}