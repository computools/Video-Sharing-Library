<?php

namespace AppBundle\Repository;

/**
 * Class DailymotionConnectionRepository
 * @package AppBundle\Repository
 */
class DailymotionConnectionRepository extends ConnectionRepository
{
    public function __construct($doctrine)
    {
        $this->setRepositoryClass();
        parent::__construct($doctrine);
    }

    protected function getRepositoryClass()
    {
        return 'AppBundle\Entity\DailymotionConnection';
    }

    protected function setRepositoryClass()
    {
        $this->repositoryClass = $this->getRepositoryClass();
    }
}