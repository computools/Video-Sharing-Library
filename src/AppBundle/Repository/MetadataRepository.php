<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Video;
use AppBundle\Entity\VideoMetadata;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class MetadataRepository
 * @package AppBundle\Repository
 */
class MetadataRepository extends AbstractEntityRepository
{
    public function __construct($doctrine)
    {
        parent::__construct($doctrine, $this->getRepositoryClass());
    }

    /**
     * @param array $metadataInfo
     * @param Video $video
     */
    public function createMetadata($metadataInfo, Video $video)
    {
        /**
         * @var VideoMetadata $metadata
         */
        $metadata = $this->create();
        $metadata->setBitrate(isset($metadataInfo['video']['bitrate'])?$metadataInfo['video']['bitrate']:null);
        $metadata->setFramerate(isset($metadataInfo['video']['frame_rate'])?$metadataInfo['video']['frame_rate']:null);
        $metadata->setResolution($metadataInfo['video']['resolution_x'] . 'x' . $metadataInfo['video']['resolution_y']);
        $metadata->setSize($metadataInfo['filesize']);
        $metadata->setVideo($video);
        $this->save($metadata);
    }

    protected function getRepositoryClass()
    {
        return 'AppBundle\Entity\VideoMetadata';
    }
}
