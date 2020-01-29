<?php


namespace App\EventListener;


use App\Entity\Brand;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BrandEventListener
{
	/** @var User $user */
	private $user;

	public function __construct(TokenStorageInterface $tokenStorage)
	{
		$this->user = ($tokenStorage->getToken()) ? $tokenStorage->getToken()->getUser() : null;
	}

	public function prePersist(Brand $brand)
	{
		$brand->setCreatedBy($this->user)
			->setUpdatedBy($this->user);
	}

	public function preUpdate(Brand $brand)
	{
		$brand->setUpdatedBy($this->user);
	}
}