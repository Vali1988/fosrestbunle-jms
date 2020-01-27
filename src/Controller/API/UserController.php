<?php


namespace App\Controller\API;


use App\Controller\BaseController;
use App\Entity\User;
use App\Forms\User\UpdateForm;
use App\Service\UserService\UserServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("/users")
 */
class UserController extends BaseController
{
	protected $formUpdate = UpdateForm::class;
	protected $entityClass = User::class;

	public function __construct(UserServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
	 * @Rest\Get("")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function cgetAction(Request $request)
	{
		return parent::cgetAction($request);
	}

	/**
	 * @Rest\Delete("/{slug}")
	 * @param $slug
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function deleteAction($slug)
	{
		return parent::deleteAction($slug);
	}

	/**
	 * @Rest\Patch("/{slug}")
	 * @param $slug
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function patchAction($slug, Request $request)
	{
		return parent::patchAction($slug, $request);
	}

	/**
	 * @Rest\Get("/{slug}")
	 * @param $slug
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function getAction($slug)
	{
		return parent::getAction($slug);
	}

	/**
	 * @Rest\Put("/{slug}")
	 * @param $slug
	 * @param Request $request
	 */
	public function putAction($slug, Request $request)
	{
		parent::putAction($slug, $request);
	}
}