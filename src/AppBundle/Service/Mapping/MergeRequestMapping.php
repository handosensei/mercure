<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\MergeRequest;

class MergeRequestMapping extends AbstractMapping implements MappingInterface
{
    public function format(array $data)
    {
        $mergeRequest = new MergeRequest();
        $date = $this->accessor->getValue($data, '[created_at]');
        $createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($date)));
        $mergeRequest
            ->setApiId($this->accessor->getValue($data, '[id]'))
            ->setCreatedAt($createdAt)
            ->setDescription($this->accessor->getValue($data, '[description]'))
            ->setStatus($this->accessor->getValue($data, '[state]'))
            ->setTitle($this->accessor->getValue($data, '[title]'))
            ->setUpvotes($this->accessor->getValue($data, '[upvotes]'))
        ;
        return $mergeRequest;
    }

}
