<?php


namespace App\Controller;


use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\Annotations as Rest;

abstract class BaseController extends AbstractFOSRestController implements RestControllerInterface
{
	protected $service;
	protected $formPost;
	protected $formUpdate;
	protected $entityClass;
	protected $identifier = 'id';

	public function newAction(){}

	public function cgetAction(Request $request)
	{
		$view = $this->view($this->service->collection($request));
		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);
	}

	public function postAction(Request $request)
	{
		$form = $this->createForm($this->formPost);
		$form->submit(json_decode($request->getContent(), true));

		if($form->isValid()) {
			$view = $this->view($this->service->add($form->getData()), 201);
		} else {
			$view = $this->view($form, 400);
		}

		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);
	}

	public function patchAction($slug, Request $request)
	{
		$entity = $this->getObjectRepository()->findOneBy([$this->identifier => $slug]);
		$form = $this->createForm($this->formUpdate, $entity, ['method' => Request::METHOD_PATCH]);

		if($form->isValid()) {
			$view = $this->service->update($form->getData());
		} else {
			$view = $this->view($form, 400);
		}

		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);
	}

	public function putAction($slug, Request $request)
	{
		// TODO: Implement putAction() method.
	}

	public function getAction($slug)
	{
		$entity = $this->getObjectRepository()->findOneBy([$this->identifier => $slug]);
		return $this->handleView($this->view($this->service->item($entity)));
	}

	public function deleteAction($slug)
	{
		$entity = $this->getObjectRepository()->findOneBy([$this->identifier => $slug]);
		$this->service->delete($entity);
		return $this->handleView( $this->view([], 204));
	}

	protected function getObjectRepository()
	{
		$em = $this->get('doctrine')->getManager();
		return $em->getRepository($this->entityClass);
	}
}