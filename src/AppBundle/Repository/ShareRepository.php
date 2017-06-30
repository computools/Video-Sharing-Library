<?php

namespace AppBundle\Repository;

/**
 * Class ShareRepository
 * @package AppBundle\Repository
 */
abstract class ShareRepository extends AbstractEntityRepository
{
    public function __construct($doctrine)
    {
        parent::__construct($doctrine, $this->getRepositoryClass());
    }

    abstract function createShare($connection, $video);
}