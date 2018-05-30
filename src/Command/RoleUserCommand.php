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

class RoleUserCommand extends Command   //Classe d�di�e aux commandes li�e � la table user
{
    private $manager;
    
    public function __construct(ObjectManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }
    
    protected function configure()  //Fonction d�finissant la syntaxe de la commande et ses param�tres
    {
        $this
            ->setName('app:user:setrole')   //D�finis le nom de la commande
            ->setDescription('Change the role of an user.') //Sa description
            ->setHelp('app:user:setrole <username> <role>') //Son utilisation 
            ->addArgument('username', InputArgument::REQUIRED, 'The user.') //Ajout d'un param�tre
            ->addArgument('roles', InputArgument::IS_ARRAY, 'The new role(s) of the user (separate multiple roles with a space).'); //Ajout d'un param�tre
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)  //Fonction ex�cutant la commande
    {
        $username = $input->getArgument('username');    //$username contient le premier param�tre entr� dans la commande
        $roles = $input->getArgument('roles');  //$roles contient le deuxi�me param�tre
        
        $userRepository = $this->manager->getRepository(User::class);   //Acc�s � la base de donn�es
        $user = $userRepository->findOneBy(['username' => $username]);  //Cr�er une requ�te SQL gr�ce au Repository
        
        $user->setRoles($roles);    //Change le r�le gr�ce � la commande setRoles de l'Entity User
        
        $this->manager->flush();    //Mets la base de donn�es � jour
        
        $output->writeln(   //Affiche de l'action r�alis� sur le terminal
            sprintf(
                'Changed user role <comment>%s</comment> to <comment>%s</comment>', $username, implode(', ', $roles)
            )
        );
    }
}