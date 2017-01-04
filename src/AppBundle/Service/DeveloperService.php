<?php

namespace AppBundle\Service;

use AppBundle\Entity\Developer;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

/**
 * UserService utilise le client GitlabClient
 */
class DeveloperService
{
    /**
     * @var ClientServiceInterface
     */
    protected $clientService;

    /**
     * @var MappingInterface
     */
    protected $developerMapping;

    /**
     * @param ClientServiceInterface $clientService
     * @param MappingInterface $mapping
     */
    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping)
    {
        $this->clientService = $clientService;
        $this->developerMapping = $mapping;
    }

    /**
     * @param string $username
     * @return null|Developer
     */
    public function getDeveloperByUsername($username)
    {
        $response = $this->clientService->getUsers(['username' => $username]);

        return $this->handleResponse($response);
    }


}
