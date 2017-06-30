<?php

namespace AppBundle\Repository;

use AppBundle\Entity\YoutubeConnection;
use Doctrine\ORM\EntityRepository;

/**
 * Class AbstractEntityRepository
 * @package AppBundle\Repository
 */
abstract class AbstractEntityRepository extends EntityRepository
{
    protected $em;
    
    abstract protected function getRepositoryClass();
    
    public function __construct($doctrine, $class)
    {
        parent::__construct($doctrine->getEntityManager(), $doctrine->getEntityManager()->getClassMetadata($class));
        $this->em = $doctrine->getEntityManager();
    }
    
    public function save($object)
    {
        $this->em->persist($object);
        $this->em->flush();
    }

    public function create()
    {
        return new $this->_entityName;
    }

    public function remove($object)
    {
        $this->em->remove($object);
        $this->em->flush();
    }
}