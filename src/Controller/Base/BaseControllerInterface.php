<?php


namespace App\Controller\Base;


use Symfony\Component\HttpFoundation\Request;

interface BaseControllerInterface
{
	function collectionGet(Request $request);
	function post(Request $request);
	function item($slug);
}