<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Video;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class VideoRepository
 * @package AppBundle\Repository
 */
class VideoRepository extends AbstractEntityRepository
{
    use ContainerAwareTrait;

    public function __construct($doctrine, $container)
    {
        parent::__construct($doctrine, $this->getRepositoryClass());
        $this->setContainer($container);
    }

    public function getVideoWithUser($id, User $user)
    {
        return $this->findOneBy([
            'id' => $id,
            'user' => $user
        ]);
    }

    public function delete(Video $video)
    {
        try {
            unlink($this->container->getParameter('video_upload_path') . $video->getFilename());
            unlink($this->container->getParameter('thumbnail_path') . $video->getThumbnail());
        } catch (\Exception $e) {

        }
        $this->remove($video);
    }

    /**
     * @param $originalName
     * @param $filename
     * @param $user
     * @param null $thumbnailName
     * @return Video
     */
    public function createVideo($originalName, $filename, $user, $thumbnailName = null)
    {
        /**
         * @var Video $video
         */
        $video = $this->create();
        $video->setFilename($filename);
        $video->setName($originalName);
        $video->setCreatedAt(new \DateTime());
        $video->setUser($user);
        $video->setThumbnail($thumbnailName);
        $this->save($video);
        return $video;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getUsersVideo(User $user)
    {
        return $this->findBy([
            'user' => $user
        ]);
    }

    protected function getRepositoryClass()
    {
        return 'AppBundle\Entity\Video';
    }
}