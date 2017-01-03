<?php

namespace ClientBundle\Service\Gitlab;

use ClientBundle\Service\GitlabService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class GitlabService
 * @package ClientBundle\Service
 */
class GroupService extends GitlabService
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
     * Récupération des groupes de l'utilisateur courant
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getOwned()
    {
        $request = new Request('GET', $this->formatUri('groups/owned'));

        return $this->client->send($request);
    }
}
