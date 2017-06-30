<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class YoutubeConnection
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 */
class DailymotionConnection extends Connection
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'dailymotion';
    }
}