<?php

namespace Knp\ProjectRequirements;

use Knp\ProjectRequirements\Application\Command\Check;
use Knp\ProjectRequirements\Application\Command\Fix;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication
{
    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        return array_merge(
            parent::getDefaultCommands(),
            [new Check(), new Fix()]
        );
    }
}
