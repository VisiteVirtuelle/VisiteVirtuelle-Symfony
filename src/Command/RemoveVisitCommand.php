<?php

namespace App\Command;

use App\Entity\Visit;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class RemoveVisitCommand extends Command
{
    private $manager;
    private $visits_dir;

    public function __construct(ObjectManager $manager, string $project_dir)
    {
        parent::__construct();
        $this->manager = $manager;
        $this->visits_dir = $project_dir.'/public/visit/';
    }

    protected function configure()
    {
        $this
            ->setName('app:visit:delete')
            ->setDescription('Delete a visit')
            ->setDefinition([
                new InputArgument('id', InputArgument::REQUIRED, 'The visit ID'),
                new InputOption('force', null, InputOption::VALUE_NONE, 'Force the deletion'),
            ])
            ->setHelp(
'The command is used to remove a visit :
    <info>php %command.full_name% <id> [--force]</info>'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $id = $input->getArgument('id');
        $force = $input->getOption('force');

        $visitRepository = $this->manager->getRepository(Visit::class);
        $visit = $visitRepository->findOneBy(['id' => $id]);

        if($visit === null)
        {
            $output->writeln(sprintf('The visit <comment>%d</comment> do not exist!', $id));
            return;
        }

        if(!$force)
        {
            $output->writeln(sprintf('ATTENTION: This operation cannot be undone!'."\n"));
            $output->writeln(sprintf('Would delete the visit <comment>%d</comment>', $id));
            $output->writeln(sprintf('Please run the operation with --force to execute'));
            $output->writeln(sprintf('The visit will be lost!'));
            return;
        }

        $filesystem = new Filesystem();
        $filesystem->remove($this->visits_dir.$id);

        $this->manager->remove($visit);
        $this->manager->flush();

        $output->writeln(sprintf('Deleted visit <comment>%d</comment>', $id));
    }
}
