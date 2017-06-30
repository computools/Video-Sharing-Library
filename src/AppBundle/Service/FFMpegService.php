<?php

namespace AppBundle\Service;

use Doctrine\ORM\Mapping\Builder\FieldBuilder;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class FFMpegService
 * @package AppBundle\Service
 */
class FFMpegService
{
    use ContainerAwareTrait;

    private $ffpmegPath;

    public function __construct($container)
    {
        $this->setContainer($container);
        $this->ffpmegPath = $this->container->getParameter('ffmpeg_path');
    }

    /**
     * @param $filename
     * @return bool|string
     */
    public function generateThumbnail($filename)
    {
        $thumbnailFile = $filename . '.png';
        $command = $this->getThumbnailCommand($filename, $thumbnailFile);

        try {
            exec($command, $output, $returnVar);
        } catch (\Exception $e) {
            return false;
        }
        return $thumbnailFile;
    }

    /**
     * @param $filename
     * @param $thumbnailFile
     * @param int $position
     * @return string
     */
    private function getThumbnailCommand($filename, $thumbnailFile, $position = 1)
    {
        return sprintf(
            '%s -ss %s -i "%s" -vframes 1 -vcodec png -an -y "%s"',
            $this->ffpmegPath,
            $position,
            $this->container->getParameter('video_upload_path') . $filename,
            $this->container->getParameter('thumbnail_path') . $thumbnailFile
        );
    }

}