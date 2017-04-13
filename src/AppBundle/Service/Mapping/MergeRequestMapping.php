<?php

namespace AppBundle\Service\Mapping;

use AppBundle\Entity\MergeRequest;
use AppBundle\Repository\DeveloperRepository;
use AppBundle\Service\DeveloperService;

class MergeRequestMapping extends AbstractMapping implements MappingInterface
{
    /**
     * @var DeveloperMapping
     */
    protected $developerMapping;

    /**
     * @var DeveloperService
     */
    protected $developerService;

    /**
     * @var DeveloperRepository
     */
    protected $developerRepository;

    /**
     * MergeRequestMapping constructor.
     * @param DeveloperRepository $developerRepository
     * @param DeveloperService $developerService
     */
    public function __construct(DeveloperMapping $developerMapping, DeveloperRepository $developerRepository, DeveloperService $developerService)
    {
        parent::__construct();
        $this->developerMapping = $developerMapping;
        $this->developerRepository = $developerRepository;
        $this->developerService = $developerService;
    }

    public function format(array $data)
    {
        $mergeRequest = new MergeRequest();
        $date = $this->accessor->getValue($data, '[created_at]');
        $createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($date)));

        $date = $this->accessor->getValue($data, '[updated_at]');
        $updatedAt = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($date)));

        $mergeRequest
            ->setApiId($this->accessor->getValue($data, '[id]'))
            ->setCreatedAt($createdAt)
            ->setUpdatedAt($updatedAt)
            ->setDescription($this->accessor->getValue($data, '[description]'))
            ->setStatus($this->accessor->getValue($data, '[state]'))
            ->setTitle($this->accessor->getValue($data, '[title]'))
            ->setUpvotes($this->accessor->getValue($data, '[upvotes]'))
            ->setChanges($this->accessor->getValue($data, '[changes]'))
        ;

        $this->attachDeveloper($mergeRequest, $data);

        return $mergeRequest;
    }

    /**
     * @param MergeRequest $mergeRequestOrigin
     * @param MergeRequest $mergeRequestUpdate
     * @return bool|MergeRequest
     */
    public function updateOne(MergeRequest $mergeRequestOrigin, MergeRequest $mergeRequestUpdate)
    {
        if ($mergeRequestOrigin->getApiId() != $mergeRequestUpdate->getApiId()) {
            return false;
        }
        $mergeRequestOrigin
            ->setTitle($mergeRequestUpdate->getTitle())
            ->setDescription($mergeRequestUpdate->getDescription())
            ->setStatus($mergeRequestUpdate->getStatus())
            ->setUpVotes($mergeRequestUpdate->getUpVotes())
        ;

        return $mergeRequestOrigin;
    }

    /**
     * @param MergeRequest $mergeRequest
     * @param array $data
     */
    public function attachDeveloper(MergeRequest $mergeRequest, $data)
    {
        $developerFromClient = $this->developerMapping->format((array) $this->accessor->getValue($data, '[author]'));
        $developerFromBdd = $this->developerRepository->findOneByUsername($developerFromClient->getUsername());
        if ($developerFromBdd) {
            $mergeRequest->setDeveloper($developerFromBdd);
        } else {
            $mergeRequest->setDeveloper($developerFromClient);
        }
    }
}
