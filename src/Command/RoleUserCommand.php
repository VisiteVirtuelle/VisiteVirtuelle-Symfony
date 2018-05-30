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

class RoleUserCommand extends Command   //Classe dédiée aux commandes liée à la table user
{
    private $manager;
    
    public function __construct(ObjectManager $manager)
    {
        parent::__construct();
        $this->manager = $manager;
    }
    
    protected function configure()  //Fonction définissant la syntaxe de la commande et ses paramètres
    {
        $this
            ->setName('app:user:setrole')   //Définis le nom de la commande
            ->setDescription('Change the role of an user.') //Sa description
            ->setHelp('app:user:setrole <username> <role>') //Son utilisation 
            ->addArgument('username', InputArgument::REQUIRED, 'The user.') //Ajout d'un paramètre
            ->addArgument('roles', InputArgument::IS_ARRAY, 'The new role(s) of the user (separate multiple roles with a space).'); //Ajout d'un paramètre
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)  //Fonction exécutant la commande
    {
        $username = $input->getArgument('username');    //$username contient le premier paramètre entré dans la commande
        $roles = $input->getArgument('roles');  //$roles contient le deuxième paramètre
        
        $userRepository = $this->manager->getRepository(User::class);   //Accès à la base de données
        $user = $userRepository->findOneBy(['username' => $username]);  //Créer une requête SQL grâce au Repository
        
        $user->setRoles($roles);    //Change le rôle grâce à la commande setRoles de l'Entity User
        
        $this->manager->flush();    //Mets la base de données à jour
        
        $output->writeln(   //Affiche de l'action réalisé sur le terminal
            sprintf(
                'Changed user role <comment>%s</comment> to <comment>%s</comment>', $username, implode(', ', $roles)
            )
        );
    }
}