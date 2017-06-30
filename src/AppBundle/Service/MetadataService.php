<?php

namespace AppBundle\Service;

use AppBundle\Repository\MetadataRepository;
use \getID3 as GetId3;
use AppBundle\Entity\Video;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class MetadataService
 * @package AppBundle\Service
 */
class MetadataService
{
    use ContainerAwareTrait;

    public function __construct($container)
    {
        $this->setContainer($container);
    }

    public function getMetadata(Video $video)
    {
        $source = $this->getVideoPath() . $video->getFilename();
        $getId3 = new GetId3();
        $metadata = $getId3->analyze($source);
        $this->getMetadataRepository()->createMetadata($metadata, $video);
    }

    private function getVideoPath()
    {
        return $this->container->getParameter('video_upload_path');
    }

    /**
     * @return MetadataRepository
     */
    private function getMetadataRepository()
    {
        return $this->container->get('metadata.repository');
    }
}