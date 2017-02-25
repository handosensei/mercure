<?php

namespace AppBundle\Service;

use AppBundle\Entity\MergeRequest;
use AppBundle\Entity\Project;
use AppBundle\Service\Mapping\CommitMapping;
use AppBundle\Service\Mapping\MappingInterface;
use AppBundle\Service\Mapping\MergeRequestMapping;
use ClientBundle\Filter\Gitlab\MergeRequestFilter;
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
     * Récupération des merges requests d'une projets
     *
     * @param Project $project
     * @param MergeRequestFilter $mergeRequestFilter
     * @return array|null
     */
    public function getMergeRequestByProject(Project $project, MergeRequestFilter $mergeRequestFilter)
    {
        $result = [];
        do {
            $response = $this->clientService->getMergeRequestByProject($project->getApiId(), $mergeRequestFilter);
            $mergeRequests = $this->handleResponse($response, true);
            if (null != $mergeRequests) {
                $result = array_merge($mergeRequests, $result);
                $mergeRequestFilter->increasePage();
            }
        } while (count($mergeRequests) == $mergeRequestFilter->getPerPage() || null != $mergeRequests);

        return $result;
    }

    /**
     * @param Project $project
     * @param MergeRequest $mergeRequest
     * @return array|null
     */
    public function getChange(Project $project, MergeRequest $mergeRequest)
    {
        $response = $this->clientService->getChange($project->getApiId(), $mergeRequest->getApiIid());

        return $this->handleResponse($response);
    }

    /**
     * @param Project $project
     * @param MergeRequest $mergeRequest
     * @return MergeRequest
     */
    public function getOne(Project $project, MergeRequest $mergeRequest)
    {
        $response = $this->clientService->getOne($project->getApiId(), $mergeRequest->getApiId());
        /** @var MergeRequest $mergeRequest */
        $mergeRequest = $this->handleResponse($response);
        $mergeRequest->setProject($project);

        return $mergeRequest;
    }
}
