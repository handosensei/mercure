<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\Group;
use Symfony\Component\PropertyAccess\PropertyAccess;

class GroupMapping implements MappingInterface
{
    /**
     * @inheritdoc
     */
    public function format(array $data)
    {
        $group = new Group();
        $group->setApiId($this->accessor->getValue($data, '[id]'));
        $group->setName($this->accessor->getValue($data, '[name]'));

        return $group;
    }
}
