<?php

namespace AppBundle\Service\Mapping;

interface MappingInterface
{
    /**
     * @param array $data
     * @return
     */
    public function format(array $data);
}
