<?php

namespace AppBundle\Service;

use AppBundle\Entity\Developer;
use AppBundle\Entity\Group;
use AppBundle\Entity\Project;
use AppBundle\Repository\DeveloperRepository;
use AppBundle\Repository\ProjectRepository;
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
     * @var DeveloperRepository
     */
    protected $developerRepository;

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * DeveloperService constructor.
     * @param ClientServiceInterface $clientService
     * @param MappingInterface $mapping
     * @param DeveloperRepository $developerRepository
     * @param ProjectRepository $projectRepository
     */
    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping,
        DeveloperRepository $developerRepository, ProjectRepository $projectRepository)
    {
        parent::__construct($clientService, $mapping);
        $this->developerRepository = $developerRepository;
        $this->projectRepository = $projectRepository;
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

    /**
     * @param Project $project
     * @return array|null
     */
    public function getDevelopersByProject(Project $project)
    {
        $response = $this->clientService->getDevelopersByProject($project->getApiId());

        return $this->handleResponse($response);
    }

    /**
     * @return array|null
     */
    public function saveNewDevelopers()
    {
        $developersFromBdd = $this->developerRepository->findAll();
        $listDeveloperApiId = [];
        /** @var Developer $developer */
        foreach ($developersFromBdd as $developer) {
            $listDeveloperApiId[$developer->getApiId()] = $developer;
        }

        $newDevelopers = [];
        $projects = $this->projectRepository->findAll();
        foreach ($projects as $project) {
            $developers = $this->getDevelopersByProject($project);
            if (empty($developers)) {
                continue;
            }

            foreach ($developers as $developer) {
                if (array_key_exists($developer->getApiId(), $listDeveloperApiId)) {
                    continue;
                }

                $developer
                    ->addProject($project)
//                    ->setGroup($project->getGroup())
                ;
                $newDevelopers[] = $developer;
            }
        }

        if (empty($newDevelopers)) {
            return null;
        }

        foreach($newDevelopers as $developer) {
//            dump($developer->getName(), $developer->getGroup()->getName());
        }


        return $this->developerRepository->save($newDevelopers);
    }
}
