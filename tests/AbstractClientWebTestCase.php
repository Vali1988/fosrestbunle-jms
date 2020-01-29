<?php

namespace App\Tests;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class AbstractClientWebTestCase
 * @package App\Tests
 */
abstract class AbstractClientWebTestCase extends WebTestCase
{
	use FixturesTrait;

	/** @var Client */
	protected $client;
	protected $fixturesRepo;

	protected $fixtures = [
		"App\DataFixtures\UserFixtures",
		"App\DataFixtures\ProductFixtures",
		"App\DataFixtures\TagFixtures",
		"App\DataFixtures\BrandFixtures",
	];

	public function __construct($name = null, array $data = [], $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
		$this->client = static::createClient();
	}

	protected function setUp():void
	{
		self::bootKernel();
		$this->fixturesRepo = $this->loadFixtures($this->fixtures)->getReferenceRepository();
	}

	protected function request(string $method, string $uri, $content = null, array $headers = []): Response
	{
		$server = ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'];
		foreach ($headers as $key => $value) {
			if (strtolower($key) === 'content-type') {
				$server['CONTENT_TYPE'] = $value;

				continue;
			}

			$server['HTTP_'.strtoupper(str_replace('-', '_', $key))] = $value;
		}

		if (is_array($content) && false !== preg_match('#^application/(?:.+\+)?json$#', $server['CONTENT_TYPE'])) {
			$content = json_encode($content);
		}

		$this->client->request($method, $uri, [], [], $server, $content);

		return $this->client->getResponse();
	}

	/**
	 * Create a client with a default Authorization header.
	 *
	 * @param string $username
	 * @param string $password
	 *
	 * @return Client
	 */
	protected function createAuthenticatedClient($username = '', $password = '')
	{
		$this->client = static::createClient();
		$this->client->request(
			'POST',
			'/authentication_token',
			array(),
			array(),
			['CONTENT_TYPE' => 'application/json'],
			json_encode([
				'email' => $username,
				'password' => $password,
			])
		);

		$data = json_decode($this->client->getResponse()->getContent(), true);
		$client = static::createClient();
		$client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

		return $client;
	}
}
