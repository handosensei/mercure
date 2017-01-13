<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\MergeRequest;

class MergeRequestMapping extends AbstractMapping implements MappingInterface
{
    public function format(array $data)
    {
        $mergeRequest = new MergeRequest();

        return $mergeRequest;
    }

}
