<?php


namespace App\Controller\Base;

use App\Entity\User;
use App\Forms\User\RegisterForm;
use App\Service\UserService\UserServiceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/register")
 */
class RegisterController extends BaseController
{
	protected $formPost = RegisterForm::class;
	protected $entityPost = User::class;

	public function __construct(UserServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
	 * @Rest\Post("")
	 */
	public function post(Request $request)
	{
		return parent::post($request);
	}
}