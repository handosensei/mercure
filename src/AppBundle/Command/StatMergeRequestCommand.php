<?php

namespace AppBundle\Command;

use AppBundle\Entity\MergeRequest;
use AppBundle\Entity\Project;
use ClientBundle\Filter\Gitlab\MergeRequestFilter;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Commande à utiliser quotidiennement pour construire les données liés aux MR du groupe
 * Class StatMergeRequestCommand
 * @package AppBundle\Command
 */
class StatMergeRequestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:merge-request:stat')
            ->setDescription('Stat des MR sur un ou l\'ensemble des projets')
            ->addOption('state', 's', InputOption::VALUE_OPTIONAL, 'Etat des merges requests souhaités (all, merged, closed, opened)', 'all')
            ->addOption('project', 'p', InputOption::VALUE_OPTIONAL, 'Afficher le nombre de merge request pour un projet');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $io = new SymfonyStyle($input, $output);
        $io->title('Affichage des stats');

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

        $mergeRequestFilter = new MergeRequestFilter();
        $mergeRequestFilter
            ->setState($input->getOption('state'))
            ->setOrderBy('created_at')
        ;

        $mergeRequestsToSave = [];
        /** @var Project $project */
        foreach ($projects as $project) {
            $mergeRequests = $container->get('app.merge_request.service')->getMergeRequestByProject($project, $mergeRequestFilter);
            if (0 == count($mergeRequests)) {
                continue;
            }

            /** @var MergeRequest $mergeRequest */
            foreach ($mergeRequests as $mergeRequest) {
                $project->setUseMergeRequest(true);
                $mergeRequest->setProject($project);
                // On ne gère que les MR de la journée
//                if ($mergeRequest->getCreatedAt() != new \DateTime()) {
//                    continue;
//                }

                $container->get('app.commit.service')->attachCommitsToMergeRequest($mergeRequest);
                $mergeRequestsToSave[] = $mergeRequest;
            }
        }

        $container->get('app.merge_request.repository')->save($mergeRequestsToSave);
        $io->success('Terminé');
    }
}
