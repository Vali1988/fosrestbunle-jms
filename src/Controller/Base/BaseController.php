<?php


namespace App\Controller\Base;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseController extends AbstractFOSRestController implements BaseControllerInterface
{
	protected $service;
	protected $formPost;
	protected $entityClass;
	protected $identifier = 'id';

	function collectionGet(Request $request)
	{
		$view = $this->view($this->service->collection($request),  Response::HTTP_OK);
		$view->getContext()->enableMaxDepth();

		return $this->handleView($view);
	}

	public function post(Request $request)
	{
		$form = $this->createForm($this->formPost);
		$form->submit(json_decode($request->getContent(), true));
		if($form->isValid()) {
			$entity = $form->getData();
			$this->service->add($entity);
			$view = $this->view($entity, 201);
		} else {
			$view = $this->view($form, 400);
		}

		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);
	}

	public function item($slug)
	{
		$view = $this->view($this->service->item($slug, $this->identifier));
		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);
	}

	protected function getObjectRepository()
	{
		$em = $this->get('doctrine')->getManager();
		return $em->getRepository($this->entityClass);
	}
}