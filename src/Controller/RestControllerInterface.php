<?php


namespace App\Controller;


use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;

interface RestControllerInterface extends ClassResourceInterface
{
	public function cgetAction(Request $request);
	public function newAction();
	public function postAction(Request $request);
	public function putAction($slug, Request $request);
	public function patchAction($slug, Request $request);
	public function getAction($slug);
	public function deleteAction($slug);
}