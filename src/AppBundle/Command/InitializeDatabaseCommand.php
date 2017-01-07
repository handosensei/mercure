<?php

namespace AppBundle\Command;

use AppBundle\Entity\Developer;
use AppBundle\Entity\Group;
use AppBundle\Entity\Project;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitializeDatabaseCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:initialize')
            ->setDescription('Initialisation de la BDD de l\'application (groupes, projets, membres)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Initialisation de la BDD de l\'application');

        $container = $this->getContainer();

//        $projects = $container->get('app.project.service')->getAllProjects();
        $groups = $container->get('app.group.service')->getOwned();

        if (null === $groups) {
            $io->error('Pas de groupe trouvé avec le TOKEN utilisé dans la config');
            return;
        }
        $io->comment(sprintf('%s groupe(s) identifié', count($groups)));
        /** @var Group $group */
        foreach ($groups as $group) {

            $projects = $container->get('app.project.service')->getProjectsByGroup($group);
            if (null === $projects) {
                $io->error('Pas de projet trouvé appartenant au groupe %s', $group->getName());
                continue;
            }

            if ($projects instanceof Project) {
                $projects = [$projects];
            }

            $io->comment(sprintf('%s projet(s) identifié', count($groups)));

            $progressBar = $io->createProgressBar(count($projects));
            /** @var Project $project */
            foreach ($projects as $project) {
                $progressBar->advance();

                $project->setGroup($group);
                $container->get('app.project.repository')->save($project);
                $developers = $container->get('app.developer.service')->getDevelopersByProject($project);
                if (null === $developers) {
                    $io->error(sprintf('Pas de développeur trouvé sur le projet %s', $project->getName()));
                    continue;
                }

                $io->comment(sprintf('%s développeur(s) identifiés', count($developers)));
                /** @var Developer $developer */
                foreach ($developers as $developer) {

                    $io->comment(sprintf('GROUP %s, PROJET %s, DEV %s', $group->getName(), $project->getName(), $developer->getName()));
                    $developer
                        ->addProject($project)
                        ->setGroup($group)
                    ;

                    $container->get('app.developer.repository')->save($developer);
                }
            }
        }

        $io->success('Terminé');
    }
}
