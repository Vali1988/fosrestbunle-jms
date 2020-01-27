<?php


namespace App\Service\BrandService;

use App\Entity\Brand;
use Symfony\Component\HttpFoundation\Request;

interface BrandServiceInterface
{
	function checkRights(array $parameters);
	function collection(Request $request);
	function add(Brand $brand);
	function update(Brand $brand);
	function delete(Brand $brand);
	function item(Brand $brand);
}