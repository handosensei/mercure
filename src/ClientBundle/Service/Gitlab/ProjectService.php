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
     * @param integer $perPage
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getProjectsByGroup($groupApiId, $page = 1, $perPage = 100)
    {
        $url = sprintf('groups/%s/projects', $groupApiId);
        $request = new Request('GET', $this->formatUri($url, ['per_page' => $perPage, 'page' => $page]));

        return $this->client->send($request);
    }
}
