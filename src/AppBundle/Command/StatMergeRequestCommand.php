<?php

namespace AppBundle\Command;

use AppBundle\Entity\Project;
use ClientBundle\Filter\Gitlab\MergeRequestFilter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * WIP
 * Class StatMergeRequestCommand
 * @package AppBundle\Command
 */
class StatMergeRequestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:mr:build-stat')
            ->setDescription('Stat des MR sur un ou l\'ensemble des projets')
            ->addOption('state', 's', InputOption::VALUE_OPTIONAL, 'Etat des merges requests souhaités (all, merged, closed, opened)', 'merged')
            ->addOption('project', 'p', InputOption::VALUE_OPTIONAL, 'Afficher le nombre de merge request pour un projet');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $io = new SymfonyStyle($input, $output);
        $io->title('Affichage des stats');

        $mergeRequestFilter = new MergeRequestFilter();
        $mergeRequestFilter->setState($input->getOption('state'));

        $projects = [];
        if ('' != $input->getOption('project')) {
            $project = $container->get('app.project.repository')->findOneByName($input->getOption('project'));
            if (!($project instanceof Project)) {
                $io->error(sprintf('Projet \'%s\' inconnu, tentez une synchronisation et relancez la commande', $input->getOption('project')));
                exit;
            }

            $projects[] = $project;
        } else {
            $projects = $container->get('app.project.repository')->findAll();
        }

        foreach ($projects as $project) {
            $mergeRequests = $container->get('app.merge_request.service')->getMergeRequestByProject($project, $mergeRequestFilter);
            if (0 == count($mergeRequests)) {
                continue;
            }
            $io->writeln(sprintf('%s merge request merged sur le projet %s', count($mergeRequests), $project->getName()));
        }

        $io->success('Terminé');
    }
}

