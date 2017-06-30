<?php

namespace AppBundle\Service;

use AppBundle\Entity\DailymotionConnection;
use AppBundle\Repository\DailymotionConnectionRepository;
use AppBundle\Entity\Share;
use AppBundle\Repository\DailymotionShareRepository;
use Buzz\Message\Form\FormRequest;

/**
 * Class DailymotionService
 * @package AppBundle\Service
 */
class DailymotionService implements SocialNetworkServiceInterface
{
    private $container;
    private $client;
    private $connection;

    public function __construct(\Dailymotion $client, $container, DailymotionConnection $dailymotionConnection)
    {
        $this->client = $client;
        $this->container = $container;
        $this->connection = $dailymotionConnection;
    }

    public function refreshToken()
    {
        $repository = $this->getDailymotionConnectionRepository();
        $tokenFields = json_decode($this->connection->getToken());
        $httpClient = new \Buzz\Browser();
        $request = new FormRequest();
        $request->setField('grant_type', 'refresh_token');
        $request->setField('refresh_token',$tokenFields->refresh_token);
        $request->setField('client_id', $this->container->getParameter('dailymotion_client_id'));
        $request->setField('client_secret', $this->container->getParameter('dailymotion_client_secret'));
        $request->setMethod('POST');
        $request->setHost('https://api.dailymotion.com');
        $request->setResource('/oauth/token');
        try {
            $transferContent = $httpClient->send($request, null);
            if ($transferContent->getStatusCode() == 200) {
                $this->connection->setToken($transferContent->getContent());
            }
            $repository->save($this->connection);
        }
        catch(\Exception $e) {
            die();
            return $e->getMessage();
        }
    }

    public function uploadVideo(Share $share)
    {
        $path = $this->container->getParameter('video_upload_path') . $share->getVideo()->getFilename();
        try {
            $url = $this->client->uploadFile($path, null, $progressUrl);
        } catch (\Exception $e) {
            $share->setStatus(Share::STATUS_FAILED);
            $share->setMessage($e->getMessage());
            $this->getDailymotionShareRepository()->save($share);
            return false;
        }

        $data = [
            'title' => $share->getVideo()->getName(),
            'url' => $url
        ];

        try {
            $response = $this->client->post('/me/videos', $data);
            $dmUrl = $response['id'];
        } catch (\Exception $e) {
            $share->setStatus(Share::STATUS_FAILED);
            $share->setMessage($e->getMessage());
            $this->getDailymotionShareRepository()->save($share);
            return false;
        }
        $share->setDailymotionUrl($dmUrl);
        $share->setStatus(Share::STATUS_SHARED);
        $this->getDailymotionShareRepository()->save($share);
        return true;
    }

    /**
     * @return DailymotionConnectionRepository
     */
    public function getDailymotionConnectionRepository()
    {
        return $this->container->get('connection.youtube.repository');
    }

    /**
     * @return DailymotionShareRepository
     */
    public function getDailymotionShareRepository()
    {
        return $this->container->get('share.youtube.repository');
    }
}