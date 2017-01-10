<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InformationGroupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:group:information')
            ->setDescription('Affichage des informations liés aux groupes existants')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Affichage des informations du groupe');

        $container = $this->getContainer();

        $group = $container->get('app.group.service')->getGroups();
        dump($group);
    }
}
