<?php

namespace AppBundle\Controller;

use AppBundle\Repository\ConnectionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Connection;

/**
 * Class ConnectionController
 * @package AppBundle\Controller
 *
 * @Route("/connection")
 */
class ConnectionController extends BaseController
{
    /**
     * @Route("/url/{type}")
     * @Method("GET")
     */
    public function getUrlAction($type)
    {
        return $this->jsonResponse([
            'url' => $this->getOauth2Service()->getAuthUrl($type)
        ]);
    }

    /**
     * @Route("/create/{type}")
     */
    public function createConnectionAction($type, Request $request)
    {
        $connection = $this->getOauth2Service()->createConnection($type, $request, $this->getUser());
        if ($connection === false) {
            return $this->redirect('/?message=Channel already exists');
        }
        return $this->redirect('/');
    }

    /**
     * @Route("/disconnect/{connectionId}", requirements={"connectionId":"\d+"})
     */
    public function disconnectConnectionAction($connectionId)
    {
        $connectionRepository = $this->getConnectionRepository();
        /**
         * @var Connection|null $connection
         */
        if ((!$connection = $connectionRepository->find($connectionId)) || ($connection->getUser()->getId() != $this->getUser()->getId())) {
            return $this->redirect('/');
        }
        $connectionRepository->remove($connection);
        return $this->redirect('/');
    }

    /**
     * @return ConnectionRepository
     */
    protected function getConnectionRepository()
    {
        return $this->get('connection.repository');
    }

}