<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    private $passwordEncoder;
    private $manager;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, ObjectManager $manager)
    {
        parent::__construct();
        $this->passwordEncoder = $passwordEncoder;
        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setName('app:user:create')
            ->setDescription('Create a new user')
            ->setDefinition([
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputOption('admin', null, InputOption::VALUE_NONE, 'Set the user as admin'),
            ])
            ->setHelp(
'The command is used to create a user :
    <info>php %command.full_name% <username> <email> <password> [--admin]</info>'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $admin = $input->getOption('admin');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $user->setEmail($email);
        $user->setRoles($admin ? ['ROLE_ADMIN'] : ['ROLE_USER']);

        $this->manager->persist($user);
        $this->manager->flush();

        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
    }
}
