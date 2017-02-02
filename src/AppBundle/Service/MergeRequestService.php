<?php

namespace AppBundle\Service;

use AppBundle\Entity\MergeRequest;
use AppBundle\Entity\Project;
use AppBundle\Service\Mapping\MappingInterface;
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
     * @param MergeRequest $mergeRequest
     * @return array|null
     */
    public function getChange(MergeRequest $mergeRequest)
    {
        $response = $this->clientService->getChange($mergeRequest->getProject()->getApiId(), $mergeRequest->getApiIid());

        return $this->handleResponse($response);
    }
}
