<?php

namespace AppBundle\Service;

use AppBundle\Entity\Developer;
use AppBundle\Service\Mapping\DeveloperMapping;
use ClientBundle\Service\ClientServiceInterface;
use Symfony\Component\VarDumper\Dumper\CliDumper;

/**
 * UserService utilise le client GitlabClient
 */
class DeveloperService
{
    /**
     * @var ClientServiceInterface
     */
    protected $clientService;

    /**
     * @var DeveloperMapping
     */
    protected $developerMapping;

    /**
     * @param ClientServiceInterface $clientService
     */
    public function __construct(ClientServiceInterface $clientService, DeveloperMapping $developerMapping)
    {
        $this->clientService = $clientService;
        $this->developerMapping = $developerMapping;
    }

    /**
     * @param string $username
     * @return null|Developer
     */
    public function getDeveloperByUsername($username)
    {
        $response = $this->clientService->getUsers(['username' => $username]);

        $result = \GuzzleHttp\json_decode($response->getBody()->getContents());

        if (0 === count($result)) {
            return null;
        }

        return $this->developerMapping->format((array) $result[0]);
    }


}
