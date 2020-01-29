<?php


namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateAdminUserCommand extends Command
{
	protected static $defaultName = 'admin:create';

	private $entityManager;

	private $encoder;

	/**
	 * CreateAdminUserCommand constructor.
	 * @param string|null $name
	 * @param EntityManagerInterface $entityManager
	 * @param UserPasswordEncoderInterface $encoder
	 */
	public function __construct(string $name = null, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
	{
		parent::__construct($name);
		$this->entityManager = $entityManager;
		$this->encoder = $encoder;
	}

	protected function configure()
	{
		$this
			->setDescription('create admin users command')
			->addArgument('email', InputArgument::REQUIRED, 'email')
			->addArgument('password', InputArgument::REQUIRED, 'password')
		;
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|void|null
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$io = new SymfonyStyle($input, $output);

		$adminUser = new User();
		$adminUser
			->setEmail($input->getArgument('email'))
			->setPassword($this->encoder->encodePassword($adminUser, $input->getArgument('password')))
			->setRoles(['ROLE_ADMIN'])
			->setAgreeTerms(true);

		$this->entityManager->persist($adminUser);
		$this->entityManager->flush();

		$io->success("User created.");
	}
}