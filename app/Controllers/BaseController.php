<?php

namespace App\Controllers;

use Interop\Container\ContainerInterface;

class BaseController
{
    protected $c;

    /**
     * Init Container.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->c = $container;
    }
}