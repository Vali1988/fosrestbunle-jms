<?php


namespace App\DataFixtures;


use App\Entity\Brand;
use Doctrine\Common\Persistence\ObjectManager;

class BrandFixtures extends BaseFixtures
{
	protected function loadData(ObjectManager $objectManager)
	{
		$brand = $this->createBrand('brand 1');
		$objectManager->persist($brand);
		$this->addReference('brand_1', $brand);

		$brand = $this->createBrand('brand 2');
		$objectManager->persist($brand);
		$this->addReference('brand_2', $brand);

		$objectManager->flush();
	}

	private function createBrand(string $name)
	{
		$brand = new Brand();
		$brand->setName($name);
		return $brand;
	}
}