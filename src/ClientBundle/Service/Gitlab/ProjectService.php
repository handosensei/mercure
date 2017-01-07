<?php

namespace ClientBundle\Service\Gitlab;

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

    /**
     * Récupère les projects d'un groupe
     * @param integer $groupApiId
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getProjectsByGroup($groupApiId)
    {
        $url = sprintf('groups/%s/projects', $groupApiId);
        $request = new Request('GET', $this->formatUri($url));

        return $this->client->send($request);
    }
}
