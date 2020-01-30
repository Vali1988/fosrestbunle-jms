<?php


namespace App\Service\TagService;


use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Request;

interface TagServiceInterface
{
	function checkRights(array $parameters);
	function add(Tag $tag);
	function delete(string $slug, string $identifier = 'id');
	function update(Tag $tag);
	function collection(Request $request);
	function item(string $slug, string $identifier = 'id');
}