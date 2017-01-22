<?php

namespace ClientBundle\Service\Gitlab;

use ClientBundle\Filter\Gitlab\MergeRequestFilter;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

class MergeRequestService extends AbstractGitlabService
{
    /**
     * GitlabService constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client, $token)
    {
        parent::__construct($client, $token);
    }

    /**
     * @param integer $projectApiId
     * @param MergeRequestFilter $filter
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getMergeRequestByProject($projectApiId, MergeRequestFilter $filter)
    {
        $url = sprintf('projects/%s/merge_requests', $projectApiId);
        $request = new Request('GET', $this->formatUri($url, $filter->getParameters()));

        return $this->client->send($request);
    }
}
