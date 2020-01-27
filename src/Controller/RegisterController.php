<?php


namespace App\Controller;

use App\Entity\User;
use App\Forms\User\RegisterForm;
use App\Service\UserService\UserServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("/register")
 */
class RegisterController extends BaseController
{
	protected $formPost = RegisterForm::class;
	protected $entityClass = User::class;

	public function __construct(UserServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
	 * @Rest\Post("")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function postAction(Request $request)
	{
		return parent::postAction($request);
	}
}