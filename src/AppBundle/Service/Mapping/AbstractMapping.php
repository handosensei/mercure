<?php

namespace AppBundle\Service\Mapping;

use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class AbstractMapping
{
    /**
     * @var PropertyAccessor
     */
    protected $accessor;

    public function __construct()
    {
        $this->accessor = PropertyAccess::createPropertyAccessor();
    }
}
