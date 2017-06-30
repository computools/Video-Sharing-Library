<?php

namespace AppBundle\Client;

use AppBundle\Entity\DailymotionConnection;

/**
 * Class DailymotionClient
 * @package AppBundle\Client
 */
class DailymotionClient extends \Dailymotion
{
    protected $connection;

    public function __construct(DailymotionConnection $dailymotionConnection)
    {
        $this->connection = $dailymotionConnection;
        $this->grantType = self::GRANT_TYPE_AUTHORIZATION;
    }

    public function getAccessToken($forceRefresh = false)
    {
        return json_decode($this->connection->getToken())->access_token;
    }
}