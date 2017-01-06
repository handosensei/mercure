<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\Project;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ProjectMapping implements MappingInterface
{
    /**
     * @inheritdoc
     */
    public function format(array $data)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        $project = new Project();
        $project->setApiId($accessor->getValue($data, '[id]'));
        $project->setName($accessor->getValue($data, '[name]'));

        return $project;
    }
}
