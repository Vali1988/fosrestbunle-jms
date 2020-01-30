<?php


namespace App\Controller\Api;

use App\Controller\Base\BaseController;
use App\Entity\Brand;
use App\Forms\Brand\BrandForm;
use App\Service\BrandService\BrandServiceInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/brands")
 */
class BrandController extends BaseController
{
	protected $formPost = BrandForm::class;
	protected $formUpdate = BrandForm::class;
	protected $entityClass = Brand::class;

	public function __construct(BrandServiceInterface $service)
	{
		$this->service = $service;
	}

	/**
	 * @Rest\Get("")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function collection(Request $request)
	{
		return parent::collection($request);
	}

	/**
	 * @Rest\Get("/{slug}")
	 * @param string $slug
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function item(string $slug)
	{
		return parent::item($slug); // TODO: Change the autogenerated stub
	}

	/**
	 * @Rest\Delete("/{slug}")
	 * @param string $slug
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function delete(string $slug)
	{
		return parent::delete($slug);
	}

	/**
	 * @Rest\Post("")
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function post(Request $request)
	{
		return parent::post($request);
	}

	/**
	 * @Rest\Patch("/{slug}")
	 * @param Request $request
	 * @param string $slug
	 * @param string $method
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function patch(Request $request, string $slug, string $method = Request::METHOD_PATCH)
	{
		return parent::update($request, $slug, $method);
	}

	/**
	 * @Rest\Put("/{slug}")
	 * @param Request $request
	 * @param string $slug
	 * @param string $method
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function put(Request $request, string $slug, string $method = Request::METHOD_PATCH)
	{
		return parent::update($request, $slug, $method);
	}
}