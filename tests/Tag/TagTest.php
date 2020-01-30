<?php


namespace App\Tests\Tag;


use App\Entity\Tag;
use App\Tests\Base;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TagTest extends Base
{
	function testGetItemTagSuccess()
	{
		$id = $this->findOneIdBy(Tag::class, 'name', 'tag 1');
		$request = $this->request(Request::METHOD_GET, '/tags/'.$id);
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testGetItemTagFailed()
	{
		$request = $this->request(Request::METHOD_GET, '/tags/85');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testCollectionTagSuccess()
	{
		$request = $this->request(Request::METHOD_GET, '/users');
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testDeleteTagSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$id = $this->findOneIdBy(Tag::class, 'name', 'tag 1');
		$request = $this->request(Request::METHOD_DELETE, '/tags/'.$id);

		$this->assertEquals(Response::HTTP_NO_CONTENT, $request->getStatusCode());
	}

	function testDeleteTagFailed()
	{
		$id = $this->findOneIdBy(Tag::class, 'name', 'tag 1');
		$request = $this->request(Request::METHOD_DELETE, '/tags/' . $id);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(Tag::class, 'name', 'tag 1');
		$request = $this->request(Request::METHOD_DELETE, '/tags/' . $id);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_DELETE, '/tags/56');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testUpdateTagSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$id = $this->findOneIdBy(Tag::class, 'name', 'tag 1');
		$request = $this->request(Request::METHOD_PATCH, '/tags/' . $id, [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testUpdateTagFailed()
	{
		$id = $this->findOneIdBy(Tag::class, 'name', 'tag 1');
		$request = $this->request(Request::METHOD_PATCH, '/tags/' . $id);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(Tag::class, 'name', 'tag 1');
		$request = $this->request(Request::METHOD_PATCH, '/tags/' . $id, [
			'name' => 'Test'
		]);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_PATCH, '/tags/56');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	function testCreateTagSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$request = $this->request(Request::METHOD_POST, '/tags', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_CREATED, $request->getStatusCode());
	}

	function testCreateTagFailed()
	{
		$request = $this->request(Request::METHOD_POST, '/tags', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());

		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_POST, '/tags', [
			'name' => 'Test Name Success'
		]);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());
	}
}