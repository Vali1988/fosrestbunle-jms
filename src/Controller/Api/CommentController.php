<?php


namespace App\Controller\Api;


use App\Controller\Base\BaseController;
use App\Entity\CommentsBrand;
use App\Entity\CommentsProduct;
use App\Forms\Comment\CommentBrand;
use App\Forms\Comment\CommentProduct;
use App\Service\CommentService\CommentServiceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/comments")
 */
class CommentController extends BaseController
{
	public function __construct(CommentServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
	 * @Rest\Post("/brands")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function postBrand(Request $request)
	{
		$this->formPost = CommentBrand::class;
		$this->entityClass = CommentsBrand::class;
		return parent::post($request);
	}

	/**
	 * @Rest\Post("/products")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function postProduct(Request $request)
	{
		$this->formPost = CommentProduct::class;
		$this->entityClass = CommentsProduct::class;
		return parent::post($request);
	}
}