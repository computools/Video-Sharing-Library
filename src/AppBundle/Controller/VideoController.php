<?php

namespace AppBundle\Controller;

use AppBundle\Repository\VideoRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VideoController
 * @package AppBundle\Controller
 *
 * @Route("/video")
 */
class VideoController extends BaseController
{
    private $allowedMimeTypes = [
        'video/mp4' => 'mp4',
        'video/x-ms-wmv' => 'wmv'
    ];

    /**
     * @Route("/{id}", requirements={"id":"\d+"})
     * @Method("GET")
     */
    public function getVideo($id)
    {
        if (!$video = $this->get('video.repository')->getVideoWithUser($id, $this->getUser())) {
            return $this->redirect('/');
        }
        return $this->render('default/video.html.twig', [
            'video' => $video
        ]);
    }


    /**
     * @Route("")
     * @Method("POST")
     */
    public function uploadAction(Request $request)
    {
        /**
         * @var UploadedFile $uploadedFile
         */
        $uploadedFile = $request->files->get('video');
        if (!isset($this->allowedMimeTypes[$uploadedFile->getClientMimeType()])) {
            return $this->redirect('/?message=Invalid type of video');
        }
        $newName = $this->getUser()->getId() . '_' . md5(uniqid()) . '.' . $uploadedFile->getClientOriginalExtension();
        $uploadedFile->move($this->getParameter('video_upload_path'), $newName);
        $videoRepository = $this->getVideoRepository();
        $thumbnailName = $this->getFFMpegService()->generateThumbnail($newName);
        $video = $videoRepository->createVideo($uploadedFile->getClientOriginalName(), $newName, $this->getUser(), $thumbnailName);
        $this->getMetadataService()->getMetadata($video);
        return $this->redirect('/');
    }

    /**
     * @Route("/delete/{id}", requirements={"id":"\d+"})
     */
    public function deleteAction($id)
    {
        /**
         * @var VideoRepository $repository
         */
        $repository = $this->get('video.repository');
        if (!$video = $repository->getVideoWithUser($id, $this->getUser())) {
            return $this->redirect('/');
        }
        $repository->delete($video);
        return $this->redirect('/');
    }
}