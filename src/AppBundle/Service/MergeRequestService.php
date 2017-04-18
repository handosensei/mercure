<?php

namespace AppBundle\Service;

use AppBundle\Entity\MergeRequest;
use AppBundle\Entity\Project;
use AppBundle\Enum\MergeRequestStatusEnum;
use AppBundle\Helper\DateHelper;
use AppBundle\Repository\MergeRequestRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\Mapping\MappingInterface;
use ClientBundle\Filter\Gitlab\MergeRequestFilter;
use ClientBundle\Service\ClientServiceInterface;
use ClientBundle\Service\Gitlab\MergeRequestService as ClientService;

/**
 * Class MergeRequestService
 * @package AppBundle\Service
 */
class MergeRequestService extends AbstractConsumerWebService
{
    /**
     * @var ClientServiceInterface
     */
    protected $clientService;

    /**
     * @var CommitService
     */
    protected $commitService;

    /**
     * @var MappingInterface
     */
    protected $mapping;

    /**
     * @var MergeRequestRepository
     */
    protected $mergeRequestRepository;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * MergeRequestService constructor.
     * @param ClientServiceInterface $clientService
     * @param CommitService $commitService
     * @param MappingInterface $mapping
     * @param MergeRequestRepository $mergeRequestRepository
     * @param UserRepository $userRepository
     */
    public function __construct(ClientServiceInterface $clientService, CommitService $commitService, MappingInterface $mapping,
                                MergeRequestRepository $mergeRequestRepository, UserRepository $userRepository)
    {
        parent::__construct($clientService, $mapping);
        $this->commitService = $commitService;
        $this->mergeRequestRepository = $mergeRequestRepository;
        $this->userRepository = $userRepository;
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
            if (null !== $mergeRequests) {
                $result = array_merge($mergeRequests, $result);
                $mergeRequestFilter->increasePage();
            }
        } while (count($mergeRequests) == $mergeRequestFilter->getPerPage() || null !== $mergeRequests);

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
        return $this->getByStatus($project, MergeRequestStatusEnum::STATUS_OPENED);
    }

    /**
     * Récupération des merges requests mergés
     * @param Project $project
     * @return array
     */
    public function getMerged(Project $project)
    {
        return $this->getByStatus($project, MergeRequestStatusEnum::STATUS_MERGED);
    }

    /**
     * Récupération des merges requests fermés
     * @param Project $project
     * @return array
     */
    public function getClosed(Project $project)
    {
        return $this->getByStatus($project, MergeRequestStatusEnum::STATUS_CLOSED);
    }

    /**
     * @param Project $project
     * @param string $status
     * @return array|bool|null
     */
    private function getByStatus(Project $project, $status)
    {
        if (!in_array($status, [MergeRequestStatusEnum::STATUS_OPENED, MergeRequestStatusEnum::STATUS_MERGED, MergeRequestStatusEnum::STATUS_CLOSED])) {
            return false;
        }

        $filter = new MergeRequestFilter();
        $filter
            ->setState($status)
            ->setOrderBy('created_at');

        return $this->getMergeRequestByProject($project, $filter);
    }

    /**
     * @param Project $project
     * @param string $key
     * @return array
     */
    public function getOpenedFromBdd(Project $project, $key = 'apiId')
    {
        $mergeRequests = $this->mergeRequestRepository->findOpened($project);

        return $this->mergeRequestRepository->parseByKey($mergeRequests, $key);
    }

    /**
     * @param Project $project
     * @return array
     */
    public function update(Project $project)
    {
        $mergeRequestsFromBdd = $this->getOpenedFromBdd($project);
        $mergeRequestsFromClient = $this->getOpened($project);
        if (0 == count($mergeRequestsFromClient)) {
            return [];
        }

        $mergeRequestToSave = [];
        foreach ($mergeRequestsFromClient as $mergeRequest) {
            /** @var MergeRequest $mergeRequest */
            if (array_key_exists($mergeRequest->getApiId(), $mergeRequestsFromBdd)) {
                $mergeRequest = $this->mapping->updateOne($mergeRequestsFromBdd[$mergeRequest->getApiId()], $mergeRequest);
            } else {
                $mergeRequest->setProject($project);
            }

            $this->mergeRequestRepository->remove($mergeRequest->getCommits());
            $mergeRequestToSave[] = $this->commitService->attachCommitsToMergeRequest($mergeRequest);
        }

        return $this->mergeRequestRepository->save($mergeRequestToSave);
    }

    /**
     * @param \DateTime $date
     * @return array
     */
    public function buildReportByMonth(\DateTime $date, $status)
    {
        $lastDay = DateHelper::getLastDatetimeAtMonth($date);

        return $this->mergeRequestRepository->findByPeriod($date, $lastDay, $status);
    }

    /**
     * @param string $status
     * @param int $depth
     * @return array
     */
    public function buildReportMonthly($status, $depth = 12)
    {
        $stats = [];
        foreach (DateHelper::getLimitEachMonth($depth) as $date) {
            $monthlyStat = $this->buildReportByMonth($date, $status);
            $stats[$date->format('Y-m')] = $monthlyStat;
        }

        return $stats;
    }

    /**
     * @param array $stats
     * @param string $status
     * @param string $rankBy
     * @return array
     */
    public function buildRankReport(array $stats = [], $status = 'merged', $rankBy = 'moy')
    {
        if (empty($stats)) {
            $stats = $this->buildReportMonthly($status);
        }

        $result = [];
        foreach ($stats as $month => $monthResume) {
            $result[$month] = $this->sortDescByMonth($monthResume, $rankBy);
        }

        return $result;
    }

    /**
     * @param array $monthResume
     * @param string $field moy ou nb
     * @return array;
     */
    public function sortDescByMonth($monthResume, $field = 'moy')
    {
        $result = [];
        foreach ($monthResume as $value) {
            $result[$value['project']] = $value[$field];
        }

        ksort($result);
        return $result;
    }
}
