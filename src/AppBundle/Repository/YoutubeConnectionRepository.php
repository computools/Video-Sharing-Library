<?php

namespace AppBundle\Repository;

/**
 * Class YoutubeConnectionRepository
 * @package AppBundle\Repository
 */
class YoutubeConnectionRepository extends ConnectionRepository
{
    public function __construct($doctrine)
    {
        $this->setRepositoryClass();
        parent::__construct($doctrine);
    }

    protected function getRepositoryClass()
    {
        return 'AppBundle\Entity\YoutubeConnection';
    }

    protected function setRepositoryClass()
    {
        $this->repositoryClass = $this->getRepositoryClass();
    }
}