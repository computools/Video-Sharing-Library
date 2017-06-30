<?php

namespace WorkerBundle\Service\SchedulerWorker;

use WorkerBundle\Entity\SchedulerTask;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class SchedulerFactory
 * @package WorkerBundle\Service\SchedulerWorker
 */
class SchedulerFactory
{
    use ContainerAwareTrait;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function run($shedulerTask)
    {
        $worker = $this->getWorker($shedulerTask);
        $worker->run();
    }

    /**
     * @param SchedulerTask $schedulerTask
     * @return AbstractWorker
     */
    private function getWorker(SchedulerTask $schedulerTask)
    {
        switch ($schedulerTask->getType()) {
            case SchedulerTask::REFRESH_TOKEN :
                return new RefreshTokenWorker($schedulerTask, $this->container);
                break;
        }
    }
}