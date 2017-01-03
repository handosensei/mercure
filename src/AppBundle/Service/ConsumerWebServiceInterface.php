<?php

namespace AppBundle\Service;

use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

interface ConsumerWebServiceInterface
{
    /**
     * ConsumerWebServiceInterface constructor.
     * @param ClientServiceInterface $clientService
     * @param MappingInterface $mapping
     */
    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping);
}
