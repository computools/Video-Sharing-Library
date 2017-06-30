<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Share
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="core_share")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "youtube" = "YoutubeShare",
 *     "dailymotion" = "DailymotionShare"
 * })
 */
abstract class Share
{
    const STATUS_FAILED = -10;
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 10;
    const STATUS_SHARED = 20;

    abstract public function getType();

    abstract public function getUrl();

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Connection")
     * @ORM\JoinColumn(name="connection_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $connection;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Video", inversedBy="shares")
     * @ORM\JoinColumn(name="video_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $video;

    /**
     * @ORM\Column(name="shared_at", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $sharedAt;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(name="message", type="text", nullable=true)
     * @var string
     */
    private $message;

    /**
     * @ORM\Column(name="status", type="integer")
     * @var integer
     */
    private $status = self::STATUS_PENDING;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param Connection $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Video $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * @return \DateTime|null
     */
    public function getSharedAt()
    {
        return $this->sharedAt;
    }

    /**
     * @param \DateTime $sharedAt
     */
    public function setSharedAt($sharedAt)
    {
        $this->sharedAt = $sharedAt;
    }

    /**
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}