<?php

namespace AppBundle\Command;

use AppBundle\Entity\Project;
use ClientBundle\Filter\Gitlab\MergeRequestFilter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class InitializeDatabaseCommand
 * @package AppBundle\Command
 */
class DefinedProjectUseMergeRequestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:project:use-mr')
            ->setDescription('Défini si le projet utilise des merges requests')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $io = new SymfonyStyle($input, $output);
        $io->title('Projet utilisant les merges requests');

        $projects = $container->get('app.project.repository')->findNotUsingMergeRequestYet();
        if (!$projects) {
            $io->warning('aucun projet');
            return;
        }
        $filter = new MergeRequestFilter();
        $filter->setPerPage(1);

        $projectToSave = [];
        /** @var Project $project */
        foreach ($projects as $project) {
            $mergeRequests = $container->get('app.merge_request.service')->getMergeRequestByProject($project, $filter);
            if (false === (bool) $mergeRequests) {
                continue;
            }
            $project->setUseMergeRequest(true);
            $projectToSave[] = $project;
            $io->comment('Projet ' . $project->getName());
        }

        $container->get('app.project.repository')->save($projectToSave);
        $io->success('Terminé');
    }
}
