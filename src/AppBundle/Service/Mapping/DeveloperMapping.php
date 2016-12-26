<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\Developer;
use Symfony\Component\PropertyAccess\PropertyAccess;

class DeveloperMapping implements MappingInterface
{
    /**
     * @inheritdoc
     */
    public function format(array $data)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $developer = new Developer();
        $developer->setApiId($accessor->getValue($data, '[id]'));
        $developer->setName($accessor->getValue($data, '[name]'));
        $developer->setUsername($accessor->getValue($data, '[username]'));
        $developer->setState($accessor->getValue($data, '[state]'));
        $developer->setGravatarUrl($accessor->getValue($data, '[avatar_url]'));

        return $developer;
    }
}
