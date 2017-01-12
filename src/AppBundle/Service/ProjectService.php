<?php

namespace AppBundle\Service;

use AppBundle\Entity\Group;
use AppBundle\Entity\Project;
use AppBundle\Repository\GroupRepository;
use AppBundle\Repository\ProjectRepository;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

class ProjectService extends AbstractConsumerWebService
{
    /**
     * @var GroupRepository
     */
    protected $groupRepository;

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping,
        ProjectRepository $projectRepository, GroupRepository $groupRepository)
    {
        parent::__construct($clientService, $mapping);
        $this->groupRepository = $groupRepository;
        $this->projectRepository = $projectRepository;
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
    public function getProjectsByGroup(Group $group, $page = 1, $perPage = 100)
    {
        $response = $this->clientService->getProjectsByGroup($group->getApiId(), $page, $perPage);

        return $this->handleResponse($response, true);
    }

    /**
     * Consultation des nouveaux projets sur le client git et enregistrement en BDD des projets non existant
     * @return array|null
     */
    public function saveNewProjects()
    {
        $projectsFromBdd = $this->projectRepository->findAll();
        $listProjectApiIds = [];
        foreach ($projectsFromBdd as $projectSaved) {
            $listProjectApiIds[] = $projectSaved->getApiId();
        }

        $groups = $this->groupRepository->findAll();
        $projectsToSave = [];
        $page = 1;
        foreach ($groups as $group) {
            $projects = $this->getProjectsByGroup($group, $page);
            do {
                $page++;
                /** @var Project $project */
                foreach ($projects as $project) {
                    if (in_array($project->getApiId(), $listProjectApiIds)) {
                        continue;
                    }
                    $project->setGroup($group);
                    $projectsToSave[] = $project;
                }
                $projects = $this->getProjectsByGroup($group, $page);
            } while (count($projects));
        }

        if (empty($projectsToSave)) {
            return null;
        }

        return $this->projectRepository->save($projectsToSave);
    }
}
