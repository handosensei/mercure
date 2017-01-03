<?php

namespace ClientBundle\Service;

use GuzzleHttp\ClientInterface;

/**
 * Class GitlabService
 * @package ClientBundle\Service
 */
abstract class AbstractGitlabService implements ClientServiceInterface
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
     * @param array $parameters
     * @return string
     */
    protected function formatUri($uri, $parameters = array())
    {
        $data = ['private_token' => $this->token];

        if (!empty($parameters)) {
            $data = array_merge($data, $parameters);
        }

        return sprintf('%s?%s', $uri, http_build_query($data));
    }
}
