<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Squad;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadSquadData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $data = [
            ['code' => 'si-rec-pp', 'name' => 'SI-REC PP'],
            ['code' => 'si-rec-cmo', 'name' => 'SI-REC CMO'],
            ['code' => 'si-dev', 'name' => 'SI-DEV'],
            ['code' => 'si-support', 'name' => 'SI-SUPPORT'],
            ['code' => 'si-inno', 'name' => 'SI-INNO'],
            ['code' => 'si-reseau', 'name' => 'SI-RESEAU'],
            ['code' => 'si-p2m', 'name' => 'SI-P2M'],
            ['code' => 'ux-ui', 'name' => 'UX-UI'],
        ];

        foreach ($data as $val) {
            $squad = new Squad();
            $squad
                ->setName($val['name'])
                ->setCode($val['code'])
            ;
            $manager->persist($squad);
        }

        $manager->flush();
    }
}
