<?php


namespace App\EventListener;


use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProductEventListener
{
	/** @var User $user */
	private $user;

	public function __construct(TokenStorageInterface $tokenStorage)
	{
		$this->user = ($tokenStorage->getToken()) ? $tokenStorage->getToken()->getUser() : null;
	}

	public function prePersist(Product $product)
	{
		$product->setCreatedBy($this->user)
			->setUpdatedBy($this->user);
	}

	public function preUpdate(Product $product)
	{
		$product->setUpdatedBy($this->user);
	}
}