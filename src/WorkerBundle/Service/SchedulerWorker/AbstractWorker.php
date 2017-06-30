<?php

namespace WorkerBundle\Service\SchedulerWorker;

use WorkerBundle\Entity\SchedulerTask;
use AppBundle\Repository\ConnectionRepository;
use AppBundle\Service\Factory\AbstractServiceFactory;

/**
 * Class AbstractWorker
 * @package WorkerBundle\Service\SchedulerWorker
 */
abstract class AbstractWorker
{
    protected $task;
    protected $container;

    public function __construct(SchedulerTask $task, $container)
    {
        $this->task = $task;
        $this->container = $container;
    }

    abstract public function run();

    /**
     * @return ConnectionRepository
     */
    protected function getCommonConnectionRepository()
    {
        return $this->container->get('connection.repository');
    }

    /**
     * @return ConnectionRepository
     */
    protected function getConnectionRepository($type)
    {
        return $this->container->get('connection.' . $type . '.repository');
    }

    /**
     * @param $type
     * @return AbstractServiceFactory
     */
    protected function getConnectionFactory($type)
    {
        return $this->container->get($type . '.factory');
    }

}