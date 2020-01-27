<?php


namespace App\Controller\API;


use App\Controller\BaseController;
use App\Service\TagService\TagServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("/tags")
 */
class TagController extends BaseController
{
	public function __construct(TagServiceInterface $service)
	{
		$this->service = $service;
	}

	public function cgetAction(Request $request)
	{
		return parent::cgetAction($request);
	}

	public function newAction()
	{
		// TODO: Implement newAction() method.
	}

	public function postAction(Request $request)
	{
		// TODO: Implement postAction() method.
	}

	public function putAction($slug, Request $request)
	{
		// TODO: Implement putAction() method.
	}

	public function patchAction($slug, Request $request)
	{
		// TODO: Implement patchAction() method.
	}

	public function getAction($slug)
	{
		// TODO: Implement getAction() method.
	}

	public function deleteAction($slug)
	{
		// TODO: Implement deleteAction() method.
	}
}