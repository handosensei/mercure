<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\VarDumper\Dumper\CliDumper;

class ImportGroupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:group:import')
            ->setDescription('Import d\'un group')
            ->addArgument('groupname', InputArgument::REQUIRED, 'Nom du groupe Gitlab')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $group = $container->get('app.group.service')->getOwned($input->getArgument('groupname'));

        $container->get('app.group.repository')->save($group);
    }
}
