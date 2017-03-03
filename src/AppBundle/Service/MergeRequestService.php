<?php

namespace AppBundle\Service;

use AppBundle\Entity\MergeRequest;
use AppBundle\Entity\Project;
use AppBundle\Repository\MergeRequestRepository;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Filter\Gitlab\MergeRequestFilter;
use ClientBundle\Service\ClientServiceInterface;
use ClientBundle\Service\Gitlab\MergeRequestService as ClientService;

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
     * @var MergeRequestRepository
     */
    protected $repository;

    /**
     * MergeRequestService constructor.
     * @param ClientServiceInterface $clientService
     * @param MappingInterface $mapping
     */
    public function __construct(ClientServiceInterface $clientService, MappingInterface $mapping, MergeRequestRepository $repository)
    {
        parent::__construct($clientService, $mapping);
        $this->repository = $repository;
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

    /**
     * Récupération des merges requests ouverts
     * @param Project $project
     * @return array
     */
    public function getOpened(Project $project)
    {
        return $this->getByStatus($project, ClientService::STATE_OPENED);
    }

    /**
     * Récupération des merges requests mergés
     * @param Project $project
     * @return array
     */
    public function getMerged(Project $project)
    {
        return $this->getByStatus($project, ClientService::STATE_MERGED);
    }

    /**
     * Récupération des merges requests fermés
     * @param Project $project
     * @return array
     */
    public function getClosed(Project $project)
    {
        return $this->getByStatus($project, ClientService::STATE_CLOSED);
    }

    /**
     * @param Project $project
     * @return array
     */
    public function getUnclosed(Project $project)
    {
        return array_merge(
            $this->getMerged($project),
            $this->getOpened($project)
        );
    }

    /**
     * @param Project $project
     * @param string $status
     * @return array|bool|null
     */
    private function getByStatus(Project $project, $status)
    {
        if (!in_array($status, [ClientService::STATE_OPENED, ClientService::STATE_MERGED, ClientService::STATE_CLOSED])) {
            return false;
        }

        $filter = new MergeRequestFilter();
        $filter
            ->setState($status)
            ->setOrderBy('created_at');

        return $this->getMergeRequestByProject($project, $filter);
    }
}
