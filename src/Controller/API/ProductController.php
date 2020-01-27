<?php


namespace App\Controller\API;


use App\Controller\BaseController;
use App\Service\ProductService\ProductServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Route("/products")
 */
class ProductController extends BaseController
{
	public function __construct(ProductServiceInterface $service)
	{
		$this->service = $service;
	}

	public function cgetAction(Request $request)
	{
		return parent::cgetAction($request);
	}


	public function postAction(Request $request)
	{
	}

	public function putAction($slug, Request $request)
	{
	}

	public function patchAction($slug, Request $request)
	{
	}

	public function getAction($slug)
	{
	}

	public function deleteAction($slug)
	{
	}
}