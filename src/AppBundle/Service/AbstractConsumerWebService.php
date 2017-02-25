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

    /**
     * TODO : [REFACTO] mettre $forceToArray à TRUE
     * @param Response $response
     * @param bool $forceToArray
     * @return array|null
     */
    public function handleResponse(Response $response, $forceToArray = false)
    {
        $result = \GuzzleHttp\json_decode($response->getBody()->getContents());
        if (0 === count($result)) {
            return null;
        }

        if (1 === count($result) && !$forceToArray) {
            if ($result instanceof \stdClass) {
                return $this->mapping->format((array) $result);
            }

            return $this->mapping->format((array) $result[0]);
        }

        $data = [];
        foreach ($result as $value) {
            $data[] = $this->mapping->format((array) $value);
        }

        return $data;

    }
}
