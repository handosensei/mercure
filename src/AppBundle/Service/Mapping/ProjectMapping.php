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
        $date = $this->accessor->getValue($data, '[created_at]');
        $createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($date)));
        $project = new Project();
        $project
            ->setApiId($this->accessor->getValue($data, '[id]'))
            ->setName($this->accessor->getValue($data, '[name]'))
            ->setCreatedAt($createdAt)
            ->setWebUrl($this->accessor->getValue($data, '[web_url]'))
        ;

        return $project;
    }
}
