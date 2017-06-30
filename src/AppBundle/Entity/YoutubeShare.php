<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class YoutubeShare
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 */
class YoutubeShare extends Share
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'YouTube';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'https://www.youtube.com/watch?v=' . $this->getYoutubeUrl();
    }

    /**
     * @ORM\Column(name="youtube_url", type="string")
     * @var string
     */
    private $youtubeUrl;

    /**
     * @return string
     */
    public function getYoutubeUrl()
    {
        return $this->youtubeUrl;
    }

    /**
     * @param string $youtubeUrl
     */
    public function setYoutubeUrl($youtubeUrl)
    {
        $this->youtubeUrl = $youtubeUrl;
    }
}