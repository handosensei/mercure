<?php

namespace AppBundle\Service;

use AppBundle\Entity\Developer;
use AppBundle\Entity\Group;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

/**
 * UserService utilise le client GitlabClient
 */
class DeveloperService extends AbstractConsumerWebService
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
        parent::__construct($clientService, $mapping);
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

    /**
     * @param Group $group
     * @return array|Developer|null
     */
    public function getDevelopersByGroup(Group $group)
    {
        $response = $this->clientService->getMembersFromGroup($group->getApiId());

        return $this->handleResponse($response);
    }


}
