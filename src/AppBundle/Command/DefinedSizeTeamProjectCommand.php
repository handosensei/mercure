<?php

namespace AppBundle\Command;

use AppBundle\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class DefinedSizeTeamProjectCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:project:team-size')
            ->setDescription('Définir le nombre de développeur sur un projet')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $io = new SymfonyStyle($input, $output);
        $io->title('Liste des projets pour renseigner le nombre de développeur');

        $projects = $container->get('app.project.repository')->findWithoutNumber();
        $projectToSave = [];
        if (!$projects) {
            $io->error('Aucun projet à renseigner');
            return;
        }

        /** @var Project $project */
        foreach ($projects as $project) {
            $number = $io->ask(sprintf('PROJET \'%s\', nombre de développeur:', $project->getName()), 0);
            if (0 === $number) {
                continue;
            }
            $project->setNumber($number);
            $projectToSave[] = $project;
        }

        $container->get('app.project.repository')->save($projectToSave);
        $io->success('Terminé');
    }
}
