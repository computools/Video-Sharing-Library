<?php

namespace AppBundle\Service;

use AppBundle\Repository\ConnectionRepository;
use HWI\Bundle\OAuthBundle\OAuth\ResourceOwner\AbstractResourceOwner;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use AppBundle\Entity\Connection;
use AppBundle\Entity\User;
use WorkerBundle\Entity\SchedulerTask;
use WorkerBundle\Service\SchedulerService;

/**
 * Class Oauth2Service
 * @package AppBundle\Service
 */
class Oauth2Service
{
    use ContainerAwareTrait;

    public function __construct($container)
    {
        $this->setContainer($container);
    }

    /**
     * @param string $serviceType
     * @param null|string $redirectUri
     * @return string
     */
    public function getAuthUrl($serviceType, $redirectUri = null)
    {
        $resourceOwner = $this->getResourceOwner($serviceType);
        if (!$redirectUri) {
            $redirectUri = $this->getRedirectUri($serviceType);
        }
        return $resourceOwner->getAuthorizationUrl($redirectUri);
    }

    /**
     * @param $serviceType
     * @param Request $request
     * @param User $user
     * @return Connection|bool
     */
    public function createConnection($serviceType, Request $request, User $user)
    {
        $resourceOwner = $this->getResourceOwner($serviceType);
        $accessToken = $resourceOwner->getAccessToken($request, $this->getRedirectUri($serviceType));
        $userResponse = $resourceOwner->getUserInformation($accessToken);

        $repository = $this->getConnectionRepository($serviceType);
        $connection = $repository->createConnection($userResponse, $user);
        if ($connection) {
            $this->getScheduler()->addTask(SchedulerTask::REFRESH_TOKEN, [], $connection);
        }
        return $connection;
    }

    /**
     * @param $serviceType
     * @return object
     * @throws InternalErrorException
     */
    protected function getConnectionByType($serviceType)
    {
        $className = sprintf(
            'AppBundle\Entity\%sConnection',
            ucfirst($serviceType)
        );
        if (!class_exists($className)) {
            throw new InternalErrorException('Invalid service type');
        }
        return new $className;
    }

    /**
     * @param $serviceType
     * @return AbstractResourceOwner
     */
    protected function getResourceOwner($serviceType)
    {
        return $this->container->get(sprintf(
            'hwi_oauth.resource_owner.%s',
            $serviceType
        ));
    }

    /**
     * @return SchedulerService
     */
    protected function getScheduler()
    {
        return $this->container->get('scheduler');
    }

    protected function getRedirectUri($serviceType)
    {
        return sprintf(
            $this->container->getParameter('redirect_uri') . '/connection/create/%s',
            $serviceType
        );
    }

    /**
     * @return ConnectionRepository
     */
    protected function getConnectionRepository($serviceType)
    {
        return $this->container->get('connection.' . $serviceType . '.repository');
    }
}