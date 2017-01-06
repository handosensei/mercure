<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportDeveloperCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:developer:import')
            ->setDescription('Import d\'un developpeur')
            ->addArgument('username', InputArgument::REQUIRED, 'Username du développeur')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $developer = $container->get('app.developer.service')->getDeveloperByUsername($input->getArgument('username'));

        $container->get('app.developer.repository')->save($developer);
    }
}
