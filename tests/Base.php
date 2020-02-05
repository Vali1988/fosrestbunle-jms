<?php


namespace App\Tests;

use App\Entity\User;

class Base extends AbstractClientWebTestCase
{
	function findOneIdBy(string $entityClass = User::class, string $identifier = 'id', string $value = '', string $parameter = 'Id')
	{
		$function = 'get'.$parameter;
		return static::$container->get('doctrine')
			->getRepository($entityClass)
			->findOneBy([$identifier => $value])
			->$function();
	}
}