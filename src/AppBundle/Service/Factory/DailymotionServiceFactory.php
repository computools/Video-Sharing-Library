<?php

namespace AppBundle\Service\Factory;

use AppBundle\Service\DailymotionService;
use AppBundle\Client\DailymotionClient;

class DailymotionServiceFactory extends AbstractServiceFactory implements SocialNetworkConnectionInterface
{
    public function createFromConnection($dailymotionConnection)
    {
        $dailymotion = new DailymotionClient($dailymotionConnection);
        return new DailymotionService($dailymotion, $this->container, $dailymotionConnection);
    }
}