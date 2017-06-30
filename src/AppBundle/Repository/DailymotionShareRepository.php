<?php

namespace AppBundle\Repository;

use AppBundle\Entity\DailymotionConnection;
use AppBundle\Entity\DailymotionShare;
use AppBundle\Entity\Video;

/**
 * Class DailymotionShareRepository
 * @package AppBundle\Repository
 */
class DailymotionShareRepository extends ShareRepository
{
    public function __construct($doctrine)
    {
        $this->setRepositoryClass();
        parent::__construct($doctrine);
    }

    /**
     * @param DailymotionConnection $connection
     * @param Video $video
     * @return DailymotionShare|bool
     */
    public function createShare($connection, $video)
    {
        if ($existed = $this->findOneBy([
            'video' => $video,
            'connection' => $connection
        ])) {
            return false;
        }
        /**
         * @var DailymotionShare $share
         */
        $share = $this->create();
        $share->setConnection($connection);
        $share->setVideo($video);
        $share->setCreatedAt(new \DateTime());
        $this->save($share);
        return $share;
    }

    protected function getRepositoryClass()
    {
        return 'AppBundle\Entity\DailymotionShare';
    }

    protected function setRepositoryClass()
    {
        $this->repositoryClass = $this->getRepositoryClass();
    }
}