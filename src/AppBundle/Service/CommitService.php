<?php

namespace AppBundle\Service;

use AppBundle\Entity\MergeRequest;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Service\ClientServiceInterface;

class CommitService extends AbstractConsumerWebService
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
     * Récupération des commits d'une merge request
     * @param MergeRequest $mergeRequest
     * @return array
     */
    public function attachCommitsToMergeRequest(MergeRequest $mergeRequest)
    {
        $response = $this->clientService->getCommitsByMergeRequestId(
            $mergeRequest->getProject()->getApiId(),
            $mergeRequest->getApiId()
        );

        $commits = $this->handleResponse($response, true);
        foreach ($commits as $commit) {
            $mergeRequest->addCommit($commit);
        }

        return $mergeRequest;
    }
}
