<?php

namespace ClientBundle\Service\Gitlab;

use ClientBundle\Filter\Gitlab\MergeRequestFilter;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

class MergeRequestService extends AbstractGitlabService
{
    const STATE_CLOSED = 'closed';
    const STATE_OPENED = 'opened';
    const STATE_MERGED = 'merged';

    /**
     * GitlabService constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client, $token)
    {
        parent::__construct($client, $token);
    }

    /**
     * @param int $projectApiId
     * @param MergeRequestFilter $filter
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getMergeRequestByProject($projectApiId, MergeRequestFilter $filter)
    {
        $url = sprintf('projects/%s/merge_requests', $projectApiId);
        $request = new Request('GET', $this->formatUri($url, $filter->getParameters()));

        return $this->client->send($request);
    }

    /**
     * Get change into merge request
     * @param int $projectApiId
     * @param int $mergeRequestId
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getChange($projectApiId, $mergeRequestId)
    {
        $url = sprintf('projects/%s/merge_requests/%s/changes', $projectApiId, $mergeRequestId);
        $request = new Request('GET', $this->formatUri($url));

        return $this->client->send($request);
    }

    /**
     * @param int $projectApiId
     * @param int $mergeRequestApiId
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getCommitsByMergeRequestId($projectApiId, $mergeRequestApiId)
    {
        $url = sprintf('projects/%s/merge_requests/%s/commits', $projectApiId, $mergeRequestApiId);
        $request = new Request('GET', $this->formatUri($url));

        return $this->client->send($request);
    }

    /**
     * @param int $projectApiId
     * @param int $mergeRequestId
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getOne($projectApiId, $mergeRequestId)
    {
        $url = sprintf('projects/%s/merge_requests/%s', $projectApiId, $mergeRequestId);
        $request = new Request('GET', $this->formatUri($url));

        return $this->client->send($request);
    }

    /**
     * @param int $projectApiId
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getOpened($projectApiId)
    {
        return $this->getByStatus($projectApiId, self::STATE_OPENED);
    }

    /**
     * @param int $projectApiId
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getMerged($projectApiId)
    {
        return $this->getByStatus($projectApiId, self::STATE_MERGED);
    }

    /**
     * @param int $projectApiId
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getClosed($projectApiId)
    {
        return $this->getByStatus($projectApiId, self::STATE_CLOSED);
    }

    /**
     * @param int $projectApiId
     * @param string $status
     * @return \Psr\Http\Message\ResponseInterface|bool
     */
    private function getByStatus($projectApiId, $status)
    {
        if (!in_array($status, [self::STATE_OPENED, self::STATE_MERGED, self::STATE_CLOSED])) {
            return false;
        }

        $filter = new MergeRequestFilter();
        $filter->setState($status);

        return $this->getMergeRequestByProject($projectApiId, $filter);
    }

}
