<?php

namespace WorkerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use WorkerBundle\Entity\SchedulerTask;

/**
 * Class CronController
 * @package WorkerBundle\Controller
 *
 * @Route("/cron")
 */
class CronController extends Controller
{
    /**
     * @Route("")
     */
    public function runScheduler()
    {
        $this->get('scheduler')->execute();
        echo 'success';
        die();
    }
}