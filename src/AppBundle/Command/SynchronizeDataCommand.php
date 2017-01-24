<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Récupération des nouveaux groupes, projets et développeurs
 *
 * Class SynchronizeDatabaseCommand
 * @package AppBundle\Command
 */
class SynchronizeDataCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:database:synchro')
            ->setDescription('Synchronisation des données (groupes, projets, développeurs)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Enregistrement des nouveaux projets');

        $container = $this->getContainer();

        $newGroups = $container->get('app.group.service')->saveNewGroups();
        if (count($newGroups)) {
            foreach ($newGroups as $group) {
                $io->comment(sprintf('nouveau groupe \'%s\' enregistré', $group->getName()));
            }
        } else {
            $io->warning('Pas de nouveau groupe');
        }

        $newProjects = $container->get('app.project.service')->saveNewProjects();
        if (count($newProjects)) {
            foreach ($newProjects as $project) {
                $io->comment(sprintf('nouveau project \'%s\' enregistré', $project->getName()));
            }
        } else {
            $io->warning('Pas de nouveau projet');
        }

        $newDevelopers = $container->get('app.developer.service')->saveNewDevelopers();
        if (count($newDevelopers)) {
            foreach ($newDevelopers as $developer) {
                $io->comment(sprintf('nouveau developpeur \'%s\' enregistré', $developer->getName()));
            }
        } else {
            $io->warning('Pas de nouveau développeur');
        }

        $io->success('Terminé');
    }
}
