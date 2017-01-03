<?php

namespace ClientBundle\Service\Gitlab;

use ClientBundle\Service\AbstractGitlabService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class GitlabService
 * @package ClientBundle\Service
 */
class UserService extends AbstractGitlabService
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
     * Récupération des utilisateurs avec un filtre (tableau associatif)
     *
     * @see https://docs.gitlab.com/ee/api/users.html#for-normal-users
     *
     * @param array $filters
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getUsers($filters = array())
    {
        $request = new Request('GET', $this->formatUri('users', $filters));

        return $this->client->send($request);
    }
}
