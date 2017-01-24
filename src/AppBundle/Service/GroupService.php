<?php

namespace AppBundle\Service;

use AppBundle\Entity\Group;
use AppBundle\Repository\GroupRepository;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

class GroupService extends AbstractConsumerWebService
{
    /**
     * @var GroupRepository
     */
    protected $repository;

    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping, GroupRepository $repository)
    {
        parent::__construct($clientService, $mapping);
        $this->repository = $repository;
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

    /**
     * @return Group|null
     */
    public function getGroups()
    {
        $response = $this->clientService->getGroups();

        return $this->handleResponse($response, true);
    }

    /**
     * Consultation des nouveaux groupes sur le client git et enregistrement en BDD des groupes non existant
     *
     * @return Group|null
     */
    public function saveNewGroups()
    {
        $groupsFromBdd = $this->repository->findAll();
        $listGroupApiIds = [];
        if (count($groupsFromBdd)) {
            foreach ($groupsFromBdd as $groupSaved) {
                $listGroupApiIds[] = $groupSaved->getApiId();
            }
        }

        $groupsFromApi = $this->getGroups();
        $groupsToSave = [];
        foreach ($groupsFromApi as $group) {
            if (in_array($group->getApiId(), $listGroupApiIds)) {
                continue;
            }

            $groupsToSave[] = $group;
        }

        if (empty($groupsToSave)) {
            return null;
        }

        return $this->repository->save($groupsToSave);
    }
}
