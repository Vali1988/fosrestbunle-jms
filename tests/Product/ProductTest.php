<?php


namespace App\Tests\Product;

use App\Entity\Product;
use App\Tests\Base;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductTest extends Base
{
	function testGetItemProductSuccess()
	{
		$id = $this->findOneIdBy(Product::class, 'name', 'product 1');
		$request = $this->request(Request::METHOD_GET, '/products/'.$id);
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testGetItemProductFailed()
	{
		$request = $this->request(Request::METHOD_GET, '/products/85');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testCollectionProductSuccess()
	{
		$request = $this->request(Request::METHOD_GET, '/users');
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testDeleteProductSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$id = $this->findOneIdBy(Product::class, 'name', 'product 1');
		$request = $this->request(Request::METHOD_DELETE, '/products/'.$id);

		$this->assertEquals(Response::HTTP_NO_CONTENT, $request->getStatusCode());
	}

	function testDeleteProductFailed()
	{
		$id = $this->findOneIdBy(Product::class, 'name', 'product 1');
		$request = $this->request(Request::METHOD_DELETE, '/products/' . $id);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(Product::class, 'name', 'product 1');
		$request = $this->request(Request::METHOD_DELETE, '/products/' . $id);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_DELETE, '/products/56');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testUpdateProductSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$id = $this->findOneIdBy(Product::class, 'name', 'product 1');
		$request = $this->request(Request::METHOD_PATCH, '/products/' . $id, [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testUpdateProductFailed()
	{
		$id = $this->findOneIdBy(Product::class, 'name', 'product 1');
		$request = $this->request(Request::METHOD_PATCH, '/products/' . $id, [
			'name' => 'Test'
		]);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(Product::class, 'name', 'product 1');
		$request = $this->request(Request::METHOD_PATCH, '/products/' . $id, [
			'name' => 'Test'
		]);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_PATCH, '/products/56');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testCreateProductSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$request = $this->request(Request::METHOD_POST, '/products', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_CREATED, $request->getStatusCode());
	}

	function testCreateProductFailed()
	{
		$request = $this->request(Request::METHOD_POST, '/products', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_POST, '/products', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());
	}
}