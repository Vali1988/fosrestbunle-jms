<?php


namespace App\Repository\Traits;


use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;

trait PaginationTrait
{
	/** @var QueryBuilder */
	protected $qb;

	public function countTotal(array $filter = [], array $search = [])
	{
		$this->qb	= $this->createQueryBuilder('c');
		$this->qb->select('count(1)')
			->setMaxResults(1);
		$this->applyFilter($filter);
		$this->applySearch($search);
		return $this->qb->getQuery()->getSingleScalarResult();
	}

	public function findResult(array $filter = [], array $search = [], array $pagination = [], array $order = ['id' => 'DESC'])
	{
		$this->qb	= $this->createQueryBuilder('c');
		$this->applyFilter($filter);
		$this->applySearch($search);
		$this->applyOrder($order);
		$this->applyPagination($pagination);

		return $this->qb->getQuery()->getResult();
	}

	private function applySearch(array $search)
	{
		foreach ($search as $key => $value) {
			$field = $key;

			$this->qb->andWhere(sprintf("c.%s LIKE :search_%s", $field, $field))
				->setParameter("search_" . $field, "%$value%");
		}
	}

	private function applyPagination(array $pagination)
	{
		if(count($pagination)) {
			$firstResult = $pagination[0];
			$lastResult = $pagination[1];

			$this->qb->setFirstResult($firstResult);

			if (!is_null($lastResult)) {
				$maxResults = $lastResult - $firstResult + 1;
				$this->qb->setMaxResults($maxResults);
			}
		}
	}

	private function applyOrder(array $order)
	{
		if (count($order) == 2) {
			$field = $order[0];
			$direction = $order[1];
			if (count(explode(".", $order[0])) > 1) {
				$fieldArray = explode(".", $order[0]);
				$field = $fieldArray[0];
			}
			$this->qb->addOrderBy("c." . $field, $direction);
		}
	}

	private function applyFilter(array $filter)
	{
		/** @var ClassMetadata $entityMetaData */
		$entityMetaData = $this->getEntityManager()->getClassMetadata($this->entity);
		foreach ($filter as $key => $value) {
			$number = 0;
			$path = explode('.', $key);
			$entity = 'c';
			$field = $path[0];
			if(!$this->checkConditionFilter($field)) { continue; }
			if (count($path) == 2 || $entityMetaData->isCollectionValuedAssociation($field)) {
				$this->qb->andWhere(':entity'.$number.' MEMBER OF c.'.$field)
					->setParameter('entity'.$number, $value);
				$number++;
				continue;
			}

			if(is_array($value)) {
				if(!empty($value)) {
					$this->qb->andWhere(sprintf("%s.%s in (:filter_%s)", $entity, $field, $field))
						->setParameter("filter_" . $field, $value);
				}
			} else if ($value === 'IS NULL' || $value === 'IS NOT NULL') {
				$this->qb->andWhere(sprintf("%s.%s " . $value, $entity, $field));
			} else {
				$this->qb->andWhere(sprintf("%s.%s = :filter_%s", $entity, $field, $field));
				$this->qb->setParameter("filter_" . $field, $value);
			}
		}
	}

	private function checkConditionFilter($field)
	{
		$entityMetaData = $this->getEntityManager()->getClassMetadata($this->entity);
		return ($entityMetaData->isCollectionValuedAssociation($field) || in_array($field, $entityMetaData->getColumnNames()));
	}
}