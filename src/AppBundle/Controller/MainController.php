<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class MainController
 * @package AppBundle\Controller
 *
 * @Route("")
 */
class MainController extends BaseController
{
    /**
     * @Route("")
     * @Method("GET")
     */
    public function indexAction()
    {
        $repository = $this->get('connection.repository');
        return $this->render('default/main.html.twig', [
            'connections' => $repository->getUserConnections($this->getUser()),
            'message' => (!empty($_GET['message'])) ? $_GET['message'] : null,
            'video' => $this->getVideoRepository()->getUsersVideo($this->getUser())
        ]);
    }
}