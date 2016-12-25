<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use FOS\UserBundle\Model\UserInterface;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('raldo');
        $user->setEmail('raldo.chea@gmail.com');
        $user->setPassword('test');
        $user->addRole(UserInterface::ROLE_SUPER_ADMIN);

        $manager->persist($user);
        $manager->flush();
    }
}
