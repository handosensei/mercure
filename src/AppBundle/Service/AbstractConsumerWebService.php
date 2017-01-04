<?php

namespace AppBundle\Service;

use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;
use GuzzleHttp\Psr7\Response;

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

    public function handleResponse(Response $response)
    {
        $result = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (0 === count($result)) {
            return null;
        }

        if (1 === count($result)) {
            return $this->mapping->format((array) $result[0]);
        }

        $data = [];
        foreach ($result as $value) {
            $data[] = $this->mapping->format((array) $value);
        }

        return $data;

    }
}
