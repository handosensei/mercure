<?php

namespace AppBundle\Command;

use ClientBundle\Client\MergeRequestFilter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StatMergeRequestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:mr:build-stat')
            ->setDescription('Stat des MR')
            ->addOption('state', 's', InputOption::VALUE_OPTIONAL, 'Etat des merges requests souhaités (all, merged, closed, opened)', 'all');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $io = new SymfonyStyle($input, $output);
        $io->title('Affichage des stats');

        $projects = $container->get('app.project.repository')->findAll();
        $mergeRequestFilter = new MergeRequestFilter();
        $mergeRequestFilter->setState($input->getOption('state'));

        foreach ($projects as $project) {
            $mergeRequests = $container->get('app.merge_request.service')->getMergeRequestByProject($project, $mergeRequestFilter);
            $io->writeln(sprintf('%s mergeRequests merged sur le projet %s', count($mergeRequests), $project->getName()));
        }

        $io->success('Terminé');
    }


}
