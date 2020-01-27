<?php


namespace App\DataFixtures;


use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends BaseFixture
{
	protected function loadData(ObjectManager $objectManager)
	{
		$tag = $this->createTag('tag 1');
		$objectManager->persist($tag);
		$this->addReference('tag_1', $tag);

		$tag = $this->createTag('tag 2');
		$objectManager->persist($tag);
		$this->addReference('tag_2', $tag);

		$objectManager->flush();
	}

	private function createTag(string $name)
	{
		$tag = new Tag();
		$tag->setName($name);
		return $tag;
	}
}