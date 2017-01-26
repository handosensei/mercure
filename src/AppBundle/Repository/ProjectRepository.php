<?php

namespace AppBundle\Repository;

class ProjectRepository extends BaseRepository
{
    /**
     * @return array
     */
    public function findWithoutNumber()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.number is null')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return array
     */
    public function findNotUsingMergeRequestYet()
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.useMergeRequest is false')
            ->getQuery()
            ->getResult()
        ;
    }
}
