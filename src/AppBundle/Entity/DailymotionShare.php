<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DailymotionShare
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 */
class DailymotionShare extends Share
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'Dailymotion';
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return 'http://www.dailymotion.com/video/' . $this->getDailymotionUrl();
    }

    /**
     * @ORM\Column(name="dailymotion_url", type="string")
     * @var string
     */
    private $dailymotionUrl;

    /**
     * @return string
     */
    public function getDailymotionUrl()
    {
        return $this->dailymotionUrl;
    }

    /**
     * @param string $dailymotionUrl
     */
    public function setDailymotionUrl($dailymotionUrl)
    {
        $this->dailymotionUrl = $dailymotionUrl;
    }
}