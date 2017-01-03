<?php

namespace AppBundle\Service;

use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

abstract class AbstractConsumerWebService implements ConsumerWebServiceInterface
{
    /**
     * @var ClientServiceInterface
     */
    protected $clientService;

    /**
     * @var MappingInterface
     */
    protected $mapping;

    /**
     * @param ClientServiceInterface $clientService
     * @param MappingInterface $mapping
     */
    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping)
    {
        $this->clientService = $clientService;
        $this->mapping = $mapping;
    }
}
