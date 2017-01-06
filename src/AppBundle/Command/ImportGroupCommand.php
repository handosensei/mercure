<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportGroupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:group:import')
            ->setDescription('Import d\'un group')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $group = $container->get('app.group.service')->getOwned();

        $container->get('app.group.repository')->save($group);
    }
}
