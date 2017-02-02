<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\Group;

class GroupMapping extends AbstractMapping implements MappingInterface
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
