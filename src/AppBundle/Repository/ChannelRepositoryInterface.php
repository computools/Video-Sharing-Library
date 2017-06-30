<?php

namespace AppBundle\Repository;

/**
 * Interface ChannelRepositoryInterface
 * @package AppBundle\Repository
 */
interface ChannelRepositoryInterface
{
    public function createShare($connection, $video);
}