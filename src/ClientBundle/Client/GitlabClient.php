<?php

namespace ClientBundle\Client;

use GuzzleHttp\Client;

class GitlabClient extends Client
{
    protected $baseUri;

    protected $timeout;

    public function __construct($baseUri, $timeout)
    {
        parent::__construct([
            'base_uri' => $baseUri,
            'timeout' => $timeout,
            'verify' => false,
        ]);
    }
}
