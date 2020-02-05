<?php


namespace App\Service\CollectionService;

use Symfony\Component\HttpFoundation\Request;

interface CollectionServiceInterface
{
	public function collection(string $entityClass, Request $request);
	public function collectionRelation(Request $request, $entity, string $entityFunction);
}