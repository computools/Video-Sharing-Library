<?php

namespace AppBundle\Repository;

use AppBundle\Entity\YoutubeConnection;
use AppBundle\Entity\Video;
use AppBundle\Entity\YoutubeShare;

/**
 * Class YoutubeShareRepository
 * @package AppBundle\Repository
 */
class YoutubeShareRepository extends ShareRepository implements ChannelRepositoryInterface
{
    public function __construct($doctrine)
    {
        $this->setRepositoryClass();
        parent::__construct($doctrine);
    }

    /**
     * @param YoutubeConnection $youtubeConnection
     * @param Video $video
     * @return YoutubeShare|bool
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
         * @var YoutubeShare $share
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
        return 'AppBundle\Entity\YoutubeShare';
    }

    protected function setRepositoryClass()
    {
        $this->repositoryClass = $this->getRepositoryClass();
    }
}