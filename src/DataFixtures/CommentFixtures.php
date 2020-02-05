<?php


namespace App\DataFixtures;


use App\Entity\Brand;
use App\Entity\CommentsBrand;
use App\Entity\CommentsProduct;
use App\Entity\Product;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixtures extends BaseFixtures implements DependentFixtureInterface
{
	protected function loadData(ObjectManager $objectManager)
	{
		$brand = $objectManager->getRepository(Brand::class)->findOneBy(['name' => 'brand 1']);
		$product = $objectManager->getRepository(Product::class)->findOneBy(['name' => 'product 1']);

		for($i = 0; $i < 5; $i++)
		{
			$comment = new CommentsBrand();
			$comment->setBrand($brand)
				->setText($this->faker->text());
			$objectManager->persist($comment);
		}

		for($i = 0; $i < 5; $i++)
		{
			$comment = new CommentsProduct();
			$comment->setProduct($product)
				->setText($this->faker->text());
			$objectManager->persist($comment);
		}

		$objectManager->flush();
	}

	/**
	 * @inheritDoc
	 */
	public function getDependencies()
	{
		return [
			BrandFixtures::class,
			ProductFixtures::class
		];
	}
}