<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use DateTime;

/**
 * ActRepository
 */
class ActRepository extends EntityRepository
{

    /**
     * Get acts by day.
     *
     * @param string $day
     * @return array
     */
    public function findByDay(DateTime $date): array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->andWhere('a.starttime > :startTime')
            ->andWhere('a.endtime < :endTime')
            ->setParameter('startTime', date('Y-m-d H:i:s', $date->getTimestamp()))
            ->setParameter('endTime', date('Y-m-d H:i:s', $date->modify('+ 23 hours')->getTimestamp()))
            ->addOrderBy('a.stage', 'asc')
            ->addOrderBy('a.starttime', 'asc');

        return $queryBuilder->getQuery()->getResult();
    }
}
