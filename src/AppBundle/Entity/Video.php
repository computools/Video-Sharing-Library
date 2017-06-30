<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
* Class Video
* @package AppBundle\Entity
*
* @ORM\Entity
* @ORM\Table(name="core_video")
*/
class Video
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
     * @ORM\Column(name="name", type="string")
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="filename", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $filename;

    /**
     * @ORM\Column(name="thumbnail", type="string", nullable=true)
     * @var string
     */
    private $thumbnail;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Share", mappedBy="video", cascade={"remove"})
     */
    private $shares;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="CASCADE")
     * @var User
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\VideoMetadata", mappedBy="video")
     * @var VideoMetadata
     */
    private $metadata;

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @return array
     */
    public function getShares()
    {
        return $this->shares;
    }

    /**
     * @param array $shares
     */
    public function setShares($shares)
    {
        $this->shares = $shares;
    }

    /**
     * @return \DateTime|null
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
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @return VideoMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param VideoMetadata $metadata
     */
    public function setMetadata($metadata)
    {
        $this->metadata = $metadata;
    }
}