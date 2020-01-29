<?php


namespace App\Repository\Traits;


use Doctrine\ORM\ORMException;
use Doctrine\ORM\Persisters\PersisterException;

trait ActionTrait
{
	/**
	 * @param $entity
	 * @throws PersisterException
	 */
	public function add($entity)
	{
		try {
			$this->getEntityManager()->persist($entity);
			$this->getEntityManager()->flush();
		} catch (ORMException $exception) {
			throw new PersisterException();
		}
	}

	/**
	 * @param  $entity
	 * @throws PersisterException
	 */
	public function delete($entity)
	{
		try {
			$this->getEntityManager()->remove($entity);
			$this->getEntityManager()->flush();
		} catch (ORMException $exception) {
			throw new PersisterException();
		}
	}
}