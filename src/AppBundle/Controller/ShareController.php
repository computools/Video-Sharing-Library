<?php

namespace AppBundle\Controller;

use AppBundle\Repository\ConnectionRepository;
use AppBundle\Repository\ShareRepository;
use AppBundle\Repository\VideoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Connection;

/**
 * Class ShareController
 * @package AppBundle\Controller
 *
 * @Route("/share")
 */
class ShareController extends BaseController
{
    /**
     * @Route("/{videoId}/{channelId}", requirements={
     *     "videoId":"\d+",
     *     "channelId":"\d+"
     * })
     * @Method("POST")
     */
    public function shareAction($videoId, $channelId)
    {
        /**
         * @var VideoRepository $repository
         */
        $repository = $this->get('video.repository');
        if (!$video = $repository->getVideoWithUser($videoId, $this->getUser())) {
            return $this->jsonResponse([], 404);
        }

        /**
         * @var ConnectionRepository $connectionRepository
         */
        $connectionRepository = $this->get('connection.repository');
        /**
         * @var Connection $connection
         */
        if (!$connection = $connectionRepository->find($channelId)) {
            return $this->jsonResponse([], 404);
        }

        /**
         * @var ShareRepository $shareRepository
         */
        $shareRepository = $this->get('share.' . $connection->getType() . '.repository');
        if (!$share = $shareRepository->createShare($connection, $video)) {
            return $this->jsonResponse([], 409);
        }

        //$this->get($connection->getType() . '.factory')->createFromConnection($connection)->refreshToken();
        try {
            $this->get($connection->getType() . '.factory')->createFromConnection($connection)->uploadVideo($share);
        } catch (\Exception $e) {
            return $this->jsonResponse([
                'error' => $e->getMessage()
            ], 500);
        }


        return $this->jsonResponse([], 200);
    }
}