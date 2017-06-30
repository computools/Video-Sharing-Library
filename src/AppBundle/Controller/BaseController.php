<?php

namespace AppBundle\Controller;

use AppBundle\Service\FFMpegService;
use AppBundle\Service\MetadataService;
use AppBundle\Service\Oauth2Service;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolationList;
use AppBundle\Service\SocialNetworkServiceInterface;
use AppBundle\Repository\VideoRepository;

/**
 * Class BaseController
 * @package AppBundle\Controller
 */
abstract class BaseController extends Controller
{
    protected function checkUser()
    {
        return $this->get('session')->has('user');
    }

    protected function jsonResponse($data, $code = 200)
    {
        return new JsonResponse($data, $code);
    }

    /**
     * @return SocialNetworkServiceInterface
     */
    protected function getConnectionFactory($type)
    {
        return $this->get($type . '.factory');
    }

    /**
     * @return UserRepository
     */
    protected function getUserRepository()
    {
        return $this->getDoctrine()->getEntityManager()->getRepository('AppBundle:User');
    }

    /**
     * @param ConstraintViolationList
     * @return array
     */
    protected function handleErrors(ConstraintViolationList $constraintViolationList)
    {
        $errors = [];
        $errors['errors'] = [];
        foreach ($constraintViolationList as $item) {
            $errors['errors'][$item->getPropertyPath()] = $item->getMessage();
        }
        return $errors;
    }

    protected function validate($class)
    {
        $validator = $this->get('validator');
        $errors = $validator->validate($class);
        if (count($errors) > 0) {
            return $this->handleErrors($errors);
        }
        return true;
    }

    /**
     * @return Oauth2Service
     */
    protected function getOauth2Service()
    {
        return $this->get('oauth2');
    }

    /**
     * @return VideoRepository
     */
    protected function getVideoRepository()
    {
        return $this->get('video.repository');
    }

    /**
     * @return FFMpegService
     */
    protected function getFFMpegService()
    {
        return $this->get('ffmpeg');
    }

    /**
     * @return MetadataService
     */
    protected function getMetadataService()
    {
        return $this->get('metadata');
    }

}