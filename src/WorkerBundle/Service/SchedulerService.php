<?php

namespace WorkerBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use WorkerBundle\Entity\SchedulerTask;
use WorkerBundle\Repository\SchedulerTaskRepository;
use WorkerBundle\Service\SchedulerWorker\SchedulerFactory;

/**
 * Class SchedulerService
 * @package WorkerBundle\Service
 */
class SchedulerService
{
    use ContainerAwareTrait;

    public function __construct($container)
    {
        $this->setContainer($container);
    }

    public function execute()
    {
        $tasks = $this->findTasks();
        /**
         * @var SchedulerTask
         */
        foreach($tasks as $task) {
            $this->run($task);
        }
    }

    public function addTask($type, $data, $connection = null)
    {
        $repository = $this->getRepository();
        /**
         * @var SchedulerTask $schedulerTask
         */
        $schedulerTask = $repository->create();
        $schedulerTask->setType($type);
        $schedulerTask->setData(json_encode($data));
        $schedulerTask->setStartDate(new \DateTime());
        $schedulerTask->setConnection($connection);
        switch ($type) {
            case SchedulerTask::REFRESH_TOKEN :
                $schedulerTask->setPeriod(3600);
                break;
            default:
                break;
        }
        $repository->save($schedulerTask);
    }

    public function run(SchedulerTask $schedulerTask)
    {
        $schedulerTask = $this->addTime($schedulerTask);
        $this->getFactory()->run($schedulerTask);
    }

    protected function addTime(SchedulerTask $schedulerTask)
    {
        if ($schedulerTask->getPeriod() !== 0) {
            $startTime = $schedulerTask->getStartDate();
            $startTime->add(new \DateInterval('PT' . $schedulerTask->getPeriod() . 'S'));
            $schedulerTask->setStartDate($startTime);
            $this->getRepository()->save($schedulerTask);
        }
        return $schedulerTask;
    }

    protected function findTasks()
    {
        return $this->getRepository()->getTasks();
    }

    /**
     * @return SchedulerTaskRepository
     */
    protected function getRepository()
    {
        return $this->container->get('scheduler.repository');
    }

    /**
     * @return SchedulerFactory
     */
    protected function getFactory()
    {
        return $this->container->get('scheduler.factory');
    }
}