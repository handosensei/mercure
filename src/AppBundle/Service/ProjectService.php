<?php

namespace AppBundle\Service;

use AppBundle\Entity\Group;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

class ProjectService extends AbstractConsumerWebService
{
    /**
     * @inheritdoc
     */
    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping)
    {
        parent::__construct($clientService, $mapping);
    }

    /**
     * @return array|null
     */
    public function getAllProjects()
    {
        $response = $this->clientService->getAllProjects();

        return $this->handleResponse($response);
    }

    /**
     * @param Group $group
     * @return array|null
     */
    public function getProjectsByGroup(Group $group)
    {
        $response = $this->clientService->getProjectsByGroup($group->getApiId());

        return $this->handleResponse($response);
    }
}
