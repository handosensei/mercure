<?php

namespace ClientBundle\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class GitlabService
 * @package ClientBundle\Service
 */
class GitlabService implements ClientServiceInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * GitlabService constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client, $token)
    {
        $this->client = $client;
        $this->token = $token;
    }

    /**
     * @param string $uri
     * @return string
     */
    private function formatUri($uri, $parameters = array())
    {
        $data = ['private_token' => $this->token];

        if (!empty($parameters)) {
            $data = array_merge($data, $parameters);
        }

        return sprintf('%s?%s', $uri, http_build_query($data));
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getUsers($filters = array())
    {
        $request = new Request('GET', $this->formatUri('users', $filters));

        return $this->client->send($request);
    }
}
