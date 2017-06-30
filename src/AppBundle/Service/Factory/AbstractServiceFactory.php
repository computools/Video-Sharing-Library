<?php

namespace AppBundle\Service\Factory;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;

abstract class AbstractServiceFactory
{
    use ContainerAwareTrait;

    public function __construct($container)
    {
        $this->setContainer($container);
    }
}