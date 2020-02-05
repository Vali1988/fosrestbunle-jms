<?php


namespace App\Tests\Brand;

use App\Entity\Brand;
use App\Tests\Base;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BrandTest extends Base
{
	function testGetItemBrandSuccess()
	{
		$id = $this->findOneIdBy(Brand::class, 'name', 'brand 1');
		$request = $this->request(Request::METHOD_GET, '/brands/'.$id);
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testGetItemBrandFailed()
	{
		$request = $this->request(Request::METHOD_GET, '/brands/85');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testCollectionBrandSuccess()
	{
		$request = $this->request(Request::METHOD_GET, '/users');
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testDeleteBrandSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$id = $this->findOneIdBy(Brand::class, 'name', 'brand 1');
		$request = $this->request(Request::METHOD_DELETE, '/brands/'.$id);

		$this->assertEquals(Response::HTTP_NO_CONTENT, $request->getStatusCode());
	}

	function testDeleteBrandFailed()
	{
		$id = $this->findOneIdBy(Brand::class, 'name', 'brand 1');
		$request = $this->request(Request::METHOD_DELETE, '/brands/' . $id);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(Brand::class, 'name', 'brand 1');
		$request = $this->request(Request::METHOD_DELETE, '/brands/' . $id);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_DELETE, '/brands/56');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testUpdateBrandSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$id = $this->findOneIdBy(Brand::class, 'name', 'brand 1');
		$request = $this->request(Request::METHOD_PATCH, '/brands/' . $id, [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testUpdateBrandFailed()
	{
		$id = $this->findOneIdBy(Brand::class, 'name', 'brand 1');
		$request = $this->request(Request::METHOD_PATCH, '/brands/' . $id);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(Brand::class, 'name', 'brand 1');
		$request = $this->request(Request::METHOD_PATCH, '/brands/' . $id, [
			'name' => 'Test'
		]);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_PATCH, '/brands/56');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testCreateBrandSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$request = $this->request(Request::METHOD_POST, '/brands', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_CREATED, $request->getStatusCode());
	}

	function testCreateBrandFailed()
	{
		$request = $this->request(Request::METHOD_POST, '/brands', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_POST, '/brands', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());
	}

	function testGetCommentByBrandSuccess()
	{
		$id = $this->findOneIdBy(Brand::class, 'name', 'brand 1', 'Slug');
		$request = $this->request(Request::METHOD_GET, '/brands/'.$id.'/comments');
		$data = json_decode($request->getContent(), true);
		$this->assertEquals(count($data['result']), $data['total']);
		$this->assertEquals(200, $request->getStatusCode());
	}

	function testGetCommentByBrandFailed()
	{
		$request = $this->request(Request::METHOD_GET, '/brands/30/comments');
		$this->assertEquals(404, $request->getStatusCode());
	}
}