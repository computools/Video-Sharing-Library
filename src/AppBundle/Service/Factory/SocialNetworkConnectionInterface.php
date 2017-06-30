<?php

namespace AppBundle\Service\Factory;

use AppBundle\Entity\Connection;

interface SocialNetworkConnectionInterface
{
    public function createFromConnection($connection);
}