<?php

namespace ClientBundle\Client;

use GuzzleHttp\Client;

class GitlabClient extends Client
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $token;

    /**
     * GitlabClient constructor.
     * @param Client $client
     */
    public function __construct(Client $client, $token)
    {
        parent::__construct($client->getConfig());
        $this->token = $token;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}
