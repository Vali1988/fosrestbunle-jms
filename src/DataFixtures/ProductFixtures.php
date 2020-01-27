<?php


namespace App\DataFixtures;


use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends BaseFixture
{
	protected function loadData(ObjectManager $objectManager)
	{
		$product = $this->createProduct('product 1');
		$objectManager->persist($product);
		$this->addReference('product_1', $product);

		$product = $this->createProduct('product 2');
		$objectManager->persist($product);
		$this->addReference('product_2', $product);

		$objectManager->flush();
	}

	private function createProduct(string $name)
	{
		$product = new Product();
		$product->setName($name);
		return $product;
	}
}