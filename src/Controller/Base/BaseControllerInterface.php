<?php


namespace App\Controller\Base;


use Symfony\Component\HttpFoundation\Request;

interface BaseControllerInterface
{
	function collection(Request $request);
	function post(Request $request);
	function item(string $slug);
	function delete(string $slug);
	function update(Request $request, string $slug, string $method = Request::METHOD_PATCH);
	function collectionRelation(Request $request, $entity, string $functionRelation);
}