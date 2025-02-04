<?php


namespace App\Service\UserService;


use App\Entity\User;
use App\Service\CollectionService\CollectionServiceInterface;
use Doctrine\DBAL\Exception\DatabaseObjectExistsException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class UserService implements UserServiceInterface
{
	private $entityManager;

	private $userPasswordEncoder;

	private $tokenStorage;

	private $authorizationChecker;

	private $collectionService;

	public function __construct(
		EntityManagerInterface $entityManager,
		UserPasswordEncoderInterface $userPasswordEncoder,
		TokenStorageInterface $tokenStorage,
		AuthorizationCheckerInterface $authorizationChecker,
		CollectionServiceInterface $collectionService)
	{
		$this->entityManager = $entityManager;
		$this->userPasswordEncoder = $userPasswordEncoder;
		$this->tokenStorage = $tokenStorage;
		$this->authorizationChecker = $authorizationChecker;
		$this->collectionService = $collectionService;
	}

	function checkRights(?User $user, array $parameters)
	{
		if($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
			return;
		}

		if($parameters['method'] == 'collection' && !$this->authorizationChecker->isGranted('ROLE_ADMIN')) {
			throw new AccessDeniedHttpException('Access Denied');
		}

		if(in_array($parameters['method'], [Request::METHOD_DELETE, Request::METHOD_PATCH])
			&& (!$this->checkCredential($user) && !$this->authorizationChecker->isGranted('ROLE_ADMIN'))) {
				throw new AccessDeniedException('Access Denied');
		}

		return;
	}

	private function checkCredential(User $user): bool
	{
		return ($this->tokenStorage->getToken()->getUser()->getId() == $user->getId());
	}

	public function getElement(string $slug, string $identifier)
	{
		$user = $this->entityManager->getRepository(User::class)->findOneBy([$identifier => $slug]);

		if(!$user) {
			throw new NotFoundHttpException('User Not Found');
		}

		return $user;
	}

	function add(User $user)
	{
		$user->setPassword($this->userPasswordEncoder->encodePassword($user, $user->getPassword()));
		$this->entityManager->getRepository(User::class)->add($user);
	}

	function delete(string $slug, string $identifier = 'id')
	{
		$user = $this->getElement($slug, $identifier);
		$this->checkRights($user, ['method' => Request::METHOD_DELETE]);
		$this->entityManager->getRepository(User::class)->delete($user);
	}

	function collection(Request $request)
	{
		return $this->collectionService->collection(User::class, $request);
	}

	function item(string $slug, string $identifier = 'id')
	{
		return $this->getElement($slug, $identifier);
	}

	function update(User $user, string $method = Request::METHOD_PATCH)
	{
		$this->checkRights($user, ['method' => $method]);
		$this->entityManager->getRepository(User::class)->add($user);
	}
}