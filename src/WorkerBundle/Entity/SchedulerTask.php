<?php

namespace WorkerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class SchedulerTask
 * @package WorkerBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="core_scheduler_task")
 */
class SchedulerTask
{
    const REFRESH_TOKEN = 'refreshToken';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="type", type="text")
     */
    private $type;

    /**
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority = 5;

    /**
     * @ORM\Column(name="period", type="integer")
     */
    private $period = 0;

    /**
     * @ORM\Column(name="data", type="text", nullable=true)
     */
    private $data = null;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Connection")
     * @ORM\JoinColumn(name="connection_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $connection;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getStartDate()
    {
        return clone $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = clone $startDate;
    }

    /**
     * @return mixed
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param mixed $period
     */
    public function setPeriod($period)
    {
        $this->period = $period;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}