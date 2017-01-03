<?php

namespace AppBundle\Service;

use AppBundle\Entity\Group;

class GroupService extends AbstractConsumerWebService
{
    /**
     * Récupération des groupes de l'utilisateur courant
     * @return null|Group
     */
    public function getOwned()
    {
        
    }
}
