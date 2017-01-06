<?php

namespace ClientBundle\Service\Gitlab;

use ClientBundle\Service\AbstractGitlabService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

class ProjectService extends AbstractGitlabService
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
     * Récupération de tous les projets
     * WARNING : seul l'admin peut faire cette requête
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getAllProjects()
    {
        $request = new Request('GET', $this->formatUri('projects/all'));

        return $this->client->send($request);
    }
}
