<?php


namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class UserFixtures extends BaseFixtures implements ContainerAwareInterface
{
	use ContainerAwareTrait;

	private function createUser($email, $role){
		$userPasswordEncoder = $this->container->get('security.password_encoder');
		$user = new User;
		$user->setName($this->faker->firstName)
			->setLastname($this->faker->lastName)
			->setEmail($email)
			->setRoles([$role])
			->setAgreeTerms(true);
		$user->setPassword($userPasswordEncoder->encodePassword($user, 'testtest'));
		return $user;
	}

	protected function loadData(ObjectManager $objectManager)
	{
		$user = $this->createUser("admin@test.com", "ROLE_ADMIN");
		$objectManager->persist($user);
		$this->addReference("admin",$user);

		$user = $this->createUser('user@test.com', 'ROLE_USER');
		$objectManager->persist($user);
		$this->addReference("user2",$user);

		$user = $this->createUser('user2@test.com', 'ROLE_USER');
		$objectManager->persist($user);
		$this->addReference("user",$user);

		$objectManager->flush();
	}
}
