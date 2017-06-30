<?php

namespace WorkerBundle\Service\SchedulerWorker;

/**
 * Class RefreshTokenWorker
 * @package WorkerBundle\Service\SchedulerWorker
 */
class RefreshTokenWorker extends AbstractWorker
{
    public function run()
    {
        $connection = $this->task->getConnection();
        $service = $this->getConnectionFactory($connection->getType())->createFromConnection($connection);
        $service->refreshToken();
    }
}