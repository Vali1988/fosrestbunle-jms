<?php


namespace App\Controller\Base;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseController extends AbstractFOSRestController implements BaseControllerInterface
{
	protected $service;
	protected $formPost;
	protected $formUpdate;
	protected $entityClass;
	protected $identifier = 'id';

	function collection(Request $request)
	{
		$view = $this->view($this->service->collection($request),  Response::HTTP_OK);
		$view->getContext()->enableMaxDepth();

		return $this->handleView($view);
	}

	public function item(string $slug)
	{
		$view = $this->view($this->service->item($slug, $this->identifier));
		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);
	}

	public function delete(string $slug)
	{
		$this->service->delete($slug, $this->identifier);
		return $this->handleView($this->view([], 204));
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

	public function update(Request $request, string $slug, string $method = Request::METHOD_PATCH)
	{
		$element = $this->service->getElement($slug, $this->identifier);
		$form = $this->createForm($this->formUpdate, $element, ['method' => $method]);
		$form->submit(json_decode($request->getContent(), true));
		if($form->isValid()) {
			$entity = $form->getData();
			$this->service->update($entity);
			$view = $this->view($entity, 200);
		} else {
			$view = $this->view($form, 400);
		}

		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);

	}

	public function collectionRelation(Request $request, $entity, string $functionRelation)
	{
		$data = $this->service->collectionRelation($request, $entity, $functionRelation);
		$view = $this->view($data);
		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);
	}
}