<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Vincent Claveau <vinc.claveau@gmail.com>
 *
 */
 
namespace App\Command;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RemoveUserCommand extends Command
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }

    protected function configure()
    {
        $this
            ->setName('app:user:delete')
            ->setDescription('Delete a user')
            ->setDefinition([
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputOption('force', null, InputOption::VALUE_NONE, 'Force the deletion'),
            ])
            ->setHelp(
'The command is used to remove a user :
    <info>php %command.full_name% <username> [--force]</info>'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $force = $input->getOption('force');

        $userRepository = $this->manager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        if($user === null)
        {
            $output->writeln(sprintf('The user named <comment>%s</comment> do not exist!', $username));
            return;
        }

        if(!$force)
        {
            $output->writeln(sprintf('ATTENTION: This operation cannot be undone!'."\n"));
            $output->writeln(sprintf('Would delete the user named <comment>%s</comment>', $username));
            $output->writeln(sprintf('Please run the operation with --force to execute'));
            $output->writeln(sprintf('The user will be lost!'));
            return;
        }

        $this->manager->remove($user);
        $this->manager->flush();

        $output->writeln(sprintf('Deleted user <comment>%s</comment>', $username));
    }
}
