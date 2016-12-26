<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
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
        $user = new User();
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'admin');
        $user
            ->setUsername('admin')
            ->setEmail('raldo.chea@gmail.com')
            ->setEnabled(true)
            ->setPassword($password)
            ->addRole(UserInterface::ROLE_SUPER_ADMIN)
        ;

        $manager->persist($user);
        $manager->flush();
    }
}
