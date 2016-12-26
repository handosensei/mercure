<?php

namespace AppBundle\Service\Mapping;

interface MappingInterface
{
    /**
     * @param array $data
     * @return object
     */
    public function format(array $data);
}
