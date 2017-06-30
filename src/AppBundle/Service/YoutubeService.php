<?php

namespace AppBundle\Service;

use AppBundle\Entity\YoutubeConnection;
use AppBundle\Repository\YoutubeConnectionRepository;
use AppBundle\Entity\YoutubeShare;
use AppBundle\Entity\Share;
use AppBundle\Repository\YoutubeShareRepository;

/**
 * Class YoutubeService
 * @package AppBundle\Service
 */
class YoutubeService implements SocialNetworkServiceInterface
{
    private $youtubeClient;
    private $connection;
    private $container;
    private $client;

    public function __construct(\Google_Service_YouTube $youtubeClient, YoutubeConnection $connection, \Google_Client $client, $container)
    {
        $this->youtubeClient = $youtubeClient;
        $this->connection = $connection;
        $this->container = $container;
        $this->client = $client;
    }

    public function refreshToken()
    {
        $this->client->refreshToken(json_decode($this->client->getAccessToken())->refresh_token);
        $this->client->getAccessToken();
        $this->connection->setToken($this->client->getAccessToken());
        $this->getYoutubeConnectionRepository()->save($this->connection);
    }

    public function uploadVideo(Share $share)
    {
        $path = $this->container->getParameter('video_upload_path') . $share->getVideo()->getFilename();
        $snippet = new \Google_Service_YouTube_VideoSnippet();
        $snippet->setTitle($share->getVideo()->getName());

        $video = new \Google_Service_YouTube_Video();
        $video->setSnippet($snippet);

        $chunkSizeBytes = 5 *1024 * 1024;
        $this->client->setDefer(true);

        $insertRequest = $this->youtubeClient->videos->insert('snippet', $video);

        $media = new \Google_Http_MediaFileUpload(
            $this->client,
            $insertRequest,
            'video/*',
            null,
            true,
            $chunkSizeBytes
        );

        $filesize = filesize($path);
        $media->setFileSize($filesize);

        $status = false;
        try {
            $handle = fopen($path, 'rb');
            while (!$status && !feof($handle)) {
                $chunk = fread($handle, $chunkSizeBytes);
                $status = $media->nextChunk($chunk);
            }
            $share->setYoutubeUrl($status->getId());
            $share->setStatus(Share::STATUS_SHARED);
            $this->getYoutubeShareRepository()->save($share);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }


    /**
     * @return YoutubeConnectionRepository
     */
    public function getYoutubeConnectionRepository()
    {
        return $this->container->get('connection.youtube.repository');
    }

    /**
     * @return YoutubeShareRepository
     */
    public function getYoutubeShareRepository()
    {
        return $this->container->get('share.youtube.repository');
    }
}