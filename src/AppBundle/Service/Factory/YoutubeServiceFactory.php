<?php

namespace AppBundle\Service\Factory;

use AppBundle\Entity\YoutubeConnection;
use AppBundle\Service\YoutubeService;
use AppBundle\Entity\Connection;
/**
 * Class YoutubeServiceFactory
 * @package AppBundle\Service\Factory
 */
class YoutubeServiceFactory extends AbstractServiceFactory implements SocialNetworkConnectionInterface
{
    /**
     * @param YoutubeConnection $youtubeConnection
     * @return YoutubeService
     */
    public function createFromConnection($youtubeConnection)
    {
        $googleClient = $this->getGoogleClient();
        $googleClient->setAccessToken($youtubeConnection->getToken());
        $youtubeClient = new \Google_Service_YouTube($googleClient);
        return new YoutubeService($youtubeClient, $youtubeConnection, $googleClient, $this->container);
    }

    /**
     * @return \Google_Client
     */
    protected function getGoogleClient()
    {
        $googleClient = new \Google_Client();
        $googleClient->setClientId($this->container->getParameter('youtube_client_id'));
        $googleClient->setClientSecret($this->container->getParameter('youtube_client_secret'));
        return $googleClient;
    }
}