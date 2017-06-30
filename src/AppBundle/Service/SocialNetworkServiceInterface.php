<?php

namespace AppBundle\Service;

use AppBundle\Entity\Share;

/**
 * Interface SocialNetworkServiceInterface
 * @package AppBundle\Service
 */
interface SocialNetworkServiceInterface
{
    public function refreshToken();

    public function uploadVideo(Share $share);
}