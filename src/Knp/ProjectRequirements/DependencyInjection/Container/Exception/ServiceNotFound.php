<?php

namespace Knp\ProjectRequirements\DependencyInjection\Container\Exception;

use Knp\ProjectRequirements\DependencyInjection\Container;
use Knp\ProjectRequirements\DependencyInjection\Container\Exception;

class ServiceNotFound extends Exception
{
    public function __construct($name, Container $container)
    {
        parent::__construct(sprintf(
            'Service %s not found, %s available.',
            $name,
            implode(',', $container->getKeys())
        ));
    }
}
