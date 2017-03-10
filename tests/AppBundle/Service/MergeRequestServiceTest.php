<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\MergeRequest;
use AppBundle\Repository\MergeRequestRepository;
use AppBundle\Service\Mapping\MergeRequestMapping;
use AppBundle\Service\MergeRequestService;
use ClientBundle\Service\Gitlab\MergeRequestService as ClientService;
use PHPUnit\Framework\TestCase;

class MergeRequestServiceTest extends TestCase
{
    protected $prophet;

    protected $clientService;

    protected $mapping;

    protected $repository;

    public function setUp()
    {
        $this->prophet = new \Prophecy\Prophet();
        $this->clientService = $this->prophet->prophesize(ClientService::class);
        $this->mapping = $this->prophet->prophesize(MergeRequestMapping::class);
        $this->repository = $this->prophet->prophesize(MergeRequestRepository::class);
    }

    public function testUpdateOne()
    {
        $service = new MergeRequestService(
            $this->clientService->reveal(),
            $this->mapping->reveal(),
            $this->repository->reveal()
        );
        $mergeRequestOrigin = new MergeRequest();
        $mergeRequestOrigin->setUpVotes(1);
        $mergeRequestUpdate = clone $mergeRequestOrigin;
        $mergeRequestUpdate->setUpVotes(3);
        $service->updateOne($mergeRequestOrigin, $mergeRequestUpdate);

        $this->assertEquals(3, $mergeRequestOrigin->getUpVotes());
    }
}
