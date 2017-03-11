<?php

namespace AppBundle\Command;

use AppBundle\Entity\MergeRequest;
use AppBundle\Entity\Project;
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
            ->addOption('project', 'p', InputOption::VALUE_OPTIONAL, 'Nom du projet à mettre à jour')
            ->addOption('verbose_command', 'vc', InputOption::VALUE_OPTIONAL, 'Afficher les mise à jours', 'y')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $io = new SymfonyStyle($input, $output);
        $io->title('Affichage des stats');

        // Récupération de l'ensemble des projets
        $projects = $this->getProjets($input, $io);

        /** @var Project $project */
        foreach ($projects as $project) {
            // Merge request à jour
            $mergeRequests = $container->get('app.merge_request.service')->update($project);
            if (0 == count($mergeRequests)) {
                continue;
            }
            $this->verbose($io, $project, $mergeRequests);
        }

        $io->success('Terminé');
    }

    /**
     * @param InputInterface $input
     * @param SymfonyStyle $io
     * @return array
     */
    private function getProjets(InputInterface $input, SymfonyStyle $io)
    {
        if ('' != $input->getOption('project')) {
            $project = $this->getContainer()->get('app.project.repository')->findOneByName($input->getOption('project'));
            if (!($project instanceof Project)) {
                $io->error(sprintf('Projet \'%s\' inconnu, tentez une synchronisation et relancez la commande', $input->getOption('project')));
                return;
            }

            $projects[] = $project;
        } else {
            $projects = $this->getContainer()->get('app.project.repository')->findAll();
        }

        return $projects;
    }

    /**
     * @param SymfonyStyle $io
     * @param Project $project
     * @param $mergeRequests
     */
    private function verbose(SymfonyStyle $io, Project $project, $mergeRequests)
    {
        $io->block(sprintf('Projet : %s', strtoupper($project->getName())));

        foreach ($mergeRequests as $mergeRequest) {
            /** @var MergeRequest $mergeRequest */
            $io->comment(sprintf('De %s : "%s"', $mergeRequest->getDeveloper()->getName(), $mergeRequest->getTitle()));
        }
    }
}
