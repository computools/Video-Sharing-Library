<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class VideoMetadata
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="core_video_metadata")
 * @ORM\Entity
 */
class VideoMetadata
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @var string
     */
    private $resolution;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $size;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @var string
     */
    private $bitrate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $framerate;

    /**
     * @ORM\OneToOne(targetEntity="Video", inversedBy="metadata")
     * @ORM\JoinColumn(name="video_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $video;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * @param string $resolution
     */
    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getBitrate()
    {
        return $this->bitrate;
    }

    /**
     * @param string $bitrate
     */
    public function setBitrate($bitrate)
    {
        $this->bitrate = $bitrate;
    }

    /**
     * @return string
     */
    public function getFramerate()
    {
        return $this->framerate;
    }

    /**
     * @param string $framerate
     */
    public function setFramerate($framerate)
    {
        $this->framerate = $framerate;
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
}