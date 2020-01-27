<?php


namespace App\Service\TagService;


use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Request;

interface TagServiceInterface
{
	function checkRights(array $parameters);
	function collection(Request $request);
	function add(Tag $tag);
	function update(Tag $tag);
	function delete(Tag $tag);
	function item(Tag $tag);
}