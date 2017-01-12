<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class InitializeDatabaseCommand
 * @package AppBundle\Command
 */
class SaveNewDeveloperCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:developer:save-new')
            ->setDescription('Enregistrement des nouveaux developpeurs')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $container = $this->getContainer();
        $io = new SymfonyStyle($input, $output);
        $io->title('Enregistrement des nouveaux developpeurs');

        $newDevelopers = $container->get('app.developer.service')->saveNewDevelopers();
        if (null === $newDevelopers) {
            $io->warning('Rien de nouveau');
            return;
        }
        foreach ($newDevelopers as $developer) {
            $io->comment(sprintf('nouveau developpeur %s enregistré', $developer->getName()));
        }

        $io->success('Terminé');
    }
}
