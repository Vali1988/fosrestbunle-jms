<?php


namespace App\EventListener;

use App\Entity\Tag;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TagEventListener
{
	/** @var User $user */
	private $user;

	public function __construct(TokenStorageInterface $tokenStorage)
	{
		$this->user = ($tokenStorage->getToken()) ? $tokenStorage->getToken()->getUser() : null;
	}

	public function prePersist(Tag $product)
	{
		$product->setCreatedBy($this->user)
			->setUpdatedBy($this->user);
	}

	public function preUpdate(Tag $product)
	{
		$product->setUpdatedBy($this->user);
	}
}