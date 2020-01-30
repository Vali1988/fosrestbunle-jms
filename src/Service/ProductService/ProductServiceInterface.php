<?php


namespace App\Service\ProductService;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

interface ProductServiceInterface
{
	function checkRights(array $parameters);
	function add(Product $brand);
	function delete(string $slug, string $identifier = 'id');
	function update(Product $brand);
	function collection(Request $request);
	function item(string $slug, string $identifier = 'id');
}