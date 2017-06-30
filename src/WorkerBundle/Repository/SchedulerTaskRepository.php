<?php

namespace WorkerBundle\Repository;

use AppBundle\Repository\AbstractEntityRepository;

/**
 * Class SchedulerTaskRepository
 * @package WorkerBundle\Repository
 */
class SchedulerTaskRepository extends AbstractEntityRepository
{
    public function __construct($doctrine)
    {
        parent::__construct($doctrine, $this->getRepositoryClass());
    }

    public function getTasks()
    {
        $now = new \DateTime();
        $query = $this->createQueryBuilder('s');
        $query->andWhere('s.startDate <= :now');
        $query->orderBy('s.priority', 'ASC');
        $query->setParameter('now', $now);
        return $query->getQuery()->getResult();
    }

    public function getRepositoryClass()
    {
        return 'WorkerBundle\Entity\SchedulerTask';
    }
}