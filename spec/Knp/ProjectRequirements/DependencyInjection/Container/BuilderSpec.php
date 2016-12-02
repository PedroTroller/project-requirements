<?php

namespace spec\Knp\ProjectRequirements\DependencyInjection\Container;

use Knp\ProjectRequirements\DependencyInjection\Container\Builder;
use PhpSpec\ObjectBehavior;

class BuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Builder::class);
    }

    function it_can_build_all_services_and_parameters_without_failure()
    {
        $container = Builder::build();
        $keys      = $container->getKeys();

        sort($keys);

        foreach ($keys as $name) {
            $service = $container[$name];

            echo sprintf('Success: %s %s', $name, "\n");
        }
    }
}
