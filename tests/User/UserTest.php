<?php


namespace App\Tests\User;

use App\Entity\User;
use App\Tests\Base;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserTest extends Base
{
	function testRegisterSuccess()
	{
		$request = $this->request(Request::METHOD_POST, '/register', [
			'email' => 'testlevel@yopmail.com',
			'password' => 'testtest',
			'agreeTerms' => true,
		]);

		$this->assertEquals(Response::HTTP_CREATED, $request->getStatusCode());
	}

	function testRegisterFailed()
	{
		$request = $this->request(Request::METHOD_POST, '/register', [
			'email' => 'user@test.com',
			'password' => 'testtest',
			'agreeTerms' => true,
		]);

		$this->assertEquals(Response::HTTP_BAD_REQUEST, $request->getStatusCode());

		$request = $this->request(Request::METHOD_POST, '/register', [
			'email' => 'testlevelcom',
			'password' => 'testtest',
			'agreeTerms' => true,
		]);

		$this->assertEquals(Response::HTTP_BAD_REQUEST, $request->getStatusCode());

		$request = $this->request(Request::METHOD_POST, '/register', [
			'email' => 'testlevelcom',
			'password' => 'testtest',
			'agreeTerm' => true,
		]);

		$this->assertEquals(Response::HTTP_BAD_REQUEST, $request->getStatusCode());

		$request = $this->request(Request::METHOD_POST, '/register', [
			'email' => 'testlevelcom',
			'password' => 'testtest',
		]);

		$this->assertEquals(Response::HTTP_BAD_REQUEST, $request->getStatusCode());
	}

	function testLoginSuccess()
	{
		$request = $this->request(Request::METHOD_POST, '/authentication_token', [
			'email' => 'user@test.com',
			'password' => 'testtest',
		]);

		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
		$this->assertArrayHasKey('token', json_decode($request->getContent(), true));
	}

	function testLoginFailed()
	{
		$request = $this->request(Request::METHOD_POST, '/authentication_token', [
			'email' => 'user3@test.com',
			'password' => 'testtest',
		]);

		$this->assertEquals(Response::HTTP_UNAUTHORIZED, $request->getStatusCode());
	}


	function testGetItemUserSuccess()
	{
		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(User::class, 'email', 'user@test.com');
		$request = $this->request(Request::METHOD_GET, '/users/'.$id);

		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testGetItemUserFailed()
	{
		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(User::class, 'email', 'user2@test.com');
		$request = $this->request(Request::METHOD_GET, '/users/'.$id);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());

		$id = $this->findOneIdBy(User::class, 'email', 'user2@test.com');
		$request = $this->request(Request::METHOD_GET, '/users/'.$id);
		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());

		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$request = $this->request(Request::METHOD_GET, '/users/85');
		$this->assertEquals(Response::HTTP_NOT_FOUND, $request->getStatusCode());
	}

	/*
	function testPatchUserSuccess()
	{
		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(User::class, 'email', 'user@test.com');
		$request = $this->request(Request::METHOD_PATCH, '/users/'.$id, [
			'name' => 'Test Name'
		]);

		$info = json_decode($request->getContent(), true);
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
		$this->assertEquals('Test Name', $info['name']);

		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$id = $this->findOneIdBy(User::class, 'email', 'user@test.com');
		$request = $this->request(Request::METHOD_PATCH, '/users/'.$id, [
			'name' => 'Test Name 2'
		]);

		$info = json_decode($request->getContent(), true);
		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
		$this->assertEquals('Test Name 2', $info['name']);
	}

	function testPatchUserFailed()
	{
		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(User::class, 'email', 'user2@test.com');
		$request = $this->request(Request::METHOD_PATCH, '/users/'.$id, [
			'name' => 'Test Name'
		]);;

		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());
	}
	*/

	function testCollectionUserSuccess()
	{
		$this->createAuthenticatedClient('admin@test.com', 'testtest');
		$request = $this->request(Request::METHOD_GET, '/users');

		$this->assertEquals(Response::HTTP_OK, $request->getStatusCode());
	}

	function testCollectionUserFailed()
	{
		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$request = $this->request(Request::METHOD_GET, '/users');

		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());
	}

	/*function testDeleteUserFailed()
	{
		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(User::class, 'email', 'user2@test.com');
		$request = $this->request(Request::METHOD_DELETE, '/users/'.$id);

		$this->assertEquals(Response::HTTP_FORBIDDEN, $request->getStatusCode());
	}

	function testDeleteUserSuccess()
	{
		$this->createAuthenticatedClient('user@test.com', 'testtest');
		$id = $this->findOneIdBy(User::class, 'email', 'user@test.com');
		$request = $this->request(Request::METHOD_DELETE, '/users/'.$id);

		$this->assertEquals(Response::HTTP_NO_CONTENT, $request->getStatusCode());

		$this->createAuthenticatedClient('user2@test.com', 'testtest');
		$id = $this->findOneIdBy(User::class, 'email', 'user2@test.com');
		$request = $this->request(Request::METHOD_DELETE, '/users/'.$id);

		$this->assertEquals(Response::HTTP_NO_CONTENT, $request->getStatusCode());
	}*/
}