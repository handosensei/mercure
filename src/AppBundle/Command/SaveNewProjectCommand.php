<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SaveNewProjectCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:project:save-new')
            ->setDescription('Enregistrement des nouveaux projets')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Enregistrement des nouveaux projets');

        $container = $this->getContainer();

        $newProjects = $container->get('app.project.service')->saveNewProjects();
        if (null === $newProjects) {
            $io->warning('Rien de nouveau');
            return;
        }
        foreach ($newProjects as $project) {
            $io->comment(sprintf('nouveau project %s enregistré', $project->getName()));
        }

        $io->success('Terminé');
    }
}
