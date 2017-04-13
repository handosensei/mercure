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

    /**
     * @param string $start
     * @param string $end
     * @param string $status
     * @return array
     */
    public function findByPeriod($start, $end, $status = null)
    {
        $query = $this->createQueryBuilder('m')
            ->select('p.slug as project', 'count(m.id) as nb', 'count(m.id)/p.number as moy')
            ->leftJoin('m.project', 'p')
            ->andWhere('m.createdAt >= :start')->setParameter('start', $start)
            ->andWhere('m.createdAt <= :end')->setParameter('end', $end)
            ->groupBy('p.slug')
        ;

        if (null != $status) {
            $query->andWhere('m.status = :status')->setParameter('status', $status);
        }

        return $query->getQuery()->getResult();
    }
}
