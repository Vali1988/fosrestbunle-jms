<?php


namespace App\Controller\Base;

use Symfony\Component\HttpFoundation\Request;

class ErrorController extends BaseController
{
	public function showAction(Request $request,  $exception)
	{
		$data = [
			'message' => $exception->getMessage(),
			'code' => $exception->getStatusCode()
		];

		$view = $this->view($data, $exception->getStatusCode());
		$view->getContext()->enableMaxDepth();
		return $this->handleView($view);
	}
}