<?php

namespace AppBundle\Command;

use AppBundle\Entity\Group;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportAllProjectsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:projects:import-all')
            ->setDescription('Import de tous les projets')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $container = $this->getContainer();

        $projects = $container->get('app.project.service')->getAllProjects();
        $io->title(sprintf('%s projets à mettre à jour'));
        $container->get('app.project.repository')->save($projects);
        $io->success('Terminé');
    }
}
