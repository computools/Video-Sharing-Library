<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Connection;
use HWI\Bundle\OAuthBundle\OAuth\Response\PathUserResponse;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use AppBundle\Entity\User;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

/**
 * Class ConnectionRepository
 * @package AppBundle\Repository
 */
class ConnectionRepository extends AbstractEntityRepository
{
    protected $repositoryClass = null;

    public function __construct($doctrine)
    {
        if (!$this->repositoryClass) {
            $this->setRepositoryClass();
        }
        parent::__construct($doctrine, $this->repositoryClass);
    }

    public function createConnection(UserResponseInterface $pathUserResponse, $user)
    {
        $response = $pathUserResponse->getResponse();

        $connection = $this->findBy([
            'accountId' => $response['id']
        ]);
        if ($connection) {
            return false;
        }
        /**
         * @var $connection Connection
         */
        $connection = $this->create();

        $connection->setUser($user);
        $connection->setAccountId($response['id']);
        $connection->setEmail($pathUserResponse->getEmail());
        $connection->setChannelName($pathUserResponse->getNickname());
        $connection->setAvatarUrl($pathUserResponse->getProfilePicture());
        $connection->setToken(json_encode($pathUserResponse->getOAuthToken()->getRawToken()));
        $connection->setCreatedAt(new \DateTime());
        $this->save($connection);
        return $connection;
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        return parent::find($id, $lockMode, $lockVersion);
    }

    public function getUserConnections(User $user)
    {
        $connections = $this->findBy([
            'user' => $user
        ]);

        return $connections;
    }


    protected function getRepositoryClass()
    {
        return 'AppBundle\Entity\Connection';
    }

    protected function setRepositoryClass()
    {
        $this->repositoryClass = $this->getRepositoryClass();
    }
}