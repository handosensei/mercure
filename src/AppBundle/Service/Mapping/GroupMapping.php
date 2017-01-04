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
        $accessor = PropertyAccess::createPropertyAccessor();

        $group = new Group();
        $group->setApiId($accessor->getValue($data, '[id]'));
        $group->setName($accessor->getValue($data, '[name]'));

        return $group;
    }
}
