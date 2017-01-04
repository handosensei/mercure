<?php

namespace AppBundle\Service;

use AppBundle\Entity\Group;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

class GroupService extends AbstractConsumerWebService
{
    /**
     * @inheritdoc
     */
    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping)
    {
        parent::__construct($clientService, $mapping);
    }

    /**
     * Récupération des groupes de l'utilisateur courant
     * @return null|Group
     */
    public function getOwned()
    {
        $response = $this->clientService->getOwned();

        return $this->handleResponse($response);
    }
}
