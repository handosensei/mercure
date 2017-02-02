<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\Developer;

class DeveloperMapping extends AbstractMapping implements MappingInterface
{
    /**
     * @inheritdoc
     */
    public function format(array $data)
    {
        $developer = new Developer();
        $developer->setApiId($this->accessor->getValue($data, '[id]'));
        $developer->setName($this->accessor->getValue($data, '[name]'));
        $developer->setUsername($this->accessor->getValue($data, '[username]'));
        $developer->setState($this->accessor->getValue($data, '[state]'));
        $developer->setGravatarUrl($this->accessor->getValue($data, '[avatar_url]'));

        return $developer;
    }
}
