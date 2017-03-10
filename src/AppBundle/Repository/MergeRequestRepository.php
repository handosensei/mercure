<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Project;

class MergeRequestRepository extends BaseRepository
{
    public function findOpened(Project $project)
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.project', 'p')
            ->andWhere('m.status = \'opened\'')
            ->andWhere('p.id = :projectId')
            ->setParameter('projectId', $project->getId())
            ->getQuery()
            ->getResult()
        ;
    }
}
