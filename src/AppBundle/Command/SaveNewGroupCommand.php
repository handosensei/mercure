<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SaveNewGroupCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:group:save-new')
            ->setDescription('Enregistrement des nouveaux groupes')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Enregistrement des nouveaux groupes');

        $container = $this->getContainer();

        $newGroups = $container->get('app.group.service')->saveNewGroups();
        if (null === $newGroups) {
            $io->warning('Rien de nouveau');
            return;
        }
        foreach ($newGroups as $group) {
            $io->comment(sprintf('nouveau groupe %s enregistré', $group->getName()));
        }

        $io->success('Terminé');
    }
}
