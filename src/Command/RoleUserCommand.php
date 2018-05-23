<?php

/*
 * This file is part of the Virtual Visit application.
 *
 * Guillaume Vidal <guillaume.vidal@lycee-bourdelle.fr>
 *
 */

namespace App\Command;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class RoleUserCommand extends Command
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
            ->setName('app:user:setrole')
            ->setDescription('Change the role of an user.')
            ->setHelp('app:user:setrole <username> <role>')
            ->addArgument('username', InputArgument::REQUIRED, 'The user.')
            ->addArgument('roles', InputArgument::IS_ARRAY, 'The new role(s) of the user (separate multiple roles with a space).');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $roles = $input->getArgument('roles');
        
        $userRepository = $this->manager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);
        
        $user->setRoles($roles);
        
        $this->manager->flush();
        
        $output->writeln(
            sprintf(
                'Changed user role <comment>%s</comment> to <comment>%s</comment>', $username, implode(', ', $roles)
            )
        );
    }
}