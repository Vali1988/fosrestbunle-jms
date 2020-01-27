<?php


namespace App\Service\ProductService;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;

interface ProductServiceInterface
{
	function checkRights(array $parameters);
	function collection(Request $request);
	function add(Product $product);
	function update(Product $product);
	function delete(Product $product);
	function item(Product $product);
}