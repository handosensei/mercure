<?php

namespace Tests\AppBundle\Service;

use AppBundle\Entity\MergeRequest;
use AppBundle\Repository\MergeRequestRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\CommitService;
use AppBundle\Service\Mapping\MergeRequestMapping;
use AppBundle\Service\MergeRequestService;
use ClientBundle\Service\Gitlab\MergeRequestService as ClientService;
use PHPUnit\Framework\TestCase;

class MergeRequestServiceTest extends TestCase
{
    protected $prophet;

    protected $clientService;

    protected $commitService;

    protected $mapping;

    protected $userRepository;

    protected $repository;

    public function setUp()
    {
        $this->prophet = new \Prophecy\Prophet();
        $this->clientService = $this->prophet->prophesize(ClientService::class);
        $this->commitService = $this->prophet->prophesize(CommitService::class);
        $this->mapping = $this->prophet->prophesize(MergeRequestMapping::class);
        $this->repository = $this->prophet->prophesize(MergeRequestRepository::class);
        $this->userRepository = $this->prophet->prophesize(UserRepository::class);
    }

    /**
     * @group sortDescByMonth
     */
    public function testSortDescByMonthEmpty()
    {
        $service = new MergeRequestService(
            $this->clientService->reveal(),
            $this->commitService->reveal(),
            $this->mapping->reveal(),
            $this->repository->reveal(),
            $this->userRepository->reveal()
        );

        $result = $service->sortDescByMonth([]);
        $this->assertNull($result);
    }

    /**
     * @group sortDescByMonth
     */
    public function testSortDescByMonth()
    {
        $service = new MergeRequestService(
            $this->clientService->reveal(),
            $this->commitService->reveal(),
            $this->mapping->reveal(),
            $this->repository->reveal(),
            $this->userRepository->reveal()
        );

        $data = [
            ['project' => 'mercure', 'moy' => '5', 'nb' => 10],
            ['project' => 'github', 'moy' => '15', 'nb' => 100],
            ['project' => 'pfo', 'moy' => '10', 'nb' => 100],
            ['project' => 'pdi', 'moy' => '3', 'nb' => 12],
        ];
        $result = $service->sortDescByMonth($data);
        $this->assertEquals(3, count($result));
    }
}
