<?php

namespace AppBundle\Command;

use AppBundle\Entity\Group;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportDevelopersByGroupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:group:import-developer')
            ->setDescription('Import des developpeurs appartenant à un groupe')
            ->addArgument('groupName', InputArgument::REQUIRED, 'Nom du groupe')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $container = $this->getContainer();

        $group = $container->get('app.group.repository')->findOneByName($input->getArgument('groupName'));
        if (!($group instanceof Group)) {
            $io->error(sprintf('Pas de groupe avec le nom %s', $input->getArgument('groupName')));
            return;
        }

        $developers = $container->get('app.developer.service')->getDevelopersByGroup($group);

        $container->get('app.developer.repository')->save($developers);
    }
}
