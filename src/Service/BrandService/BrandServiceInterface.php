<?php


namespace App\Service\BrandService;

use App\Entity\Brand;
use Symfony\Component\HttpFoundation\Request;

interface BrandServiceInterface
{
	function checkRights(array $parameters);
	function add(Brand $brand);
	function delete(string $slug, string $identifier = 'id');
	function update(Brand $brand);
	function collection(Request $request);
	function item(string $slug, string $identifier = 'id');
}