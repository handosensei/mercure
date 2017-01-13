<?php

namespace AppBundle\Service;

use AppBundle\Entity\Project;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Client\MergeRequestFilter;
use ClientBundle\Service\ClientServiceInterface;

class MergeRequestService extends AbstractConsumerWebService
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
     * MergeRequestService constructor.
     * @param ClientServiceInterface $clientService
     * @param MappingInterface $mapping
     */
    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping)
    {
        parent::__construct($clientService, $mapping);
    }

    /**
     * @param Project $project
     * @param MergeRequestFilter $mergeRequestFilter
     * @return array|null
     */
    public function getMergeRequestByProject(Project $project, MergeRequestFilter $mergeRequestFilter)
    {
        $response = $this->clientService->getMergeRequestByProject($project->getApiId(), $mergeRequestFilter);

        return $this->handleResponse($response, true);
    }
}
