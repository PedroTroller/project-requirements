<?php

namespace spec\Knp\ProjectRequirements\DependencyInjection;

use DateTime;
use Knp\ProjectRequirements\DependencyInjection\Container;
use Knp\ProjectRequirements\DependencyInjection\Container\Exception\ServiceNotFound;
use PhpSpec\ObjectBehavior;

class ContainerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Container::class);
    }

    function it_can_register_parameters()
    {
        $this['my.param'] = 'foo';

        $this['my.param']->shouldBe('foo');
    }

    function it_can_build_parameter_from_a_callable()
    {
        $this['my.callable'] = function () {
            return 'foo';
        };

        $this['my.callable']->shouldBe('foo');
    }

    function it_can_build_parameter_from_a_callable_and_an_other_parameter()
    {
        $this['my.param'] = 'foo';

        $this['my.callable'] = function (Container $container) {
            return mb_strtoupper($container['my.param']);
        };

        $this['my.callable']->shouldBe('FOO');
    }

    function it_build_a_service_just_once()
    {
        $this['my.service'] = function () {
            return DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
        };

        $this['my.service']->shouldBe($this['my.service']);
    }

    function it_throws_an_exception_if_service_of_parameter_doesnt_exists()
    {
        $this->shouldThrow(new ServiceNotFound('unknown', $this->getWrappedObject()))->duringOffsetGet('unknown');
    }
}
