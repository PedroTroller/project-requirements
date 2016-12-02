<?php

namespace spec\Knp\ProjectRequirements\Composer;

use Knp\ProjectRequirements\Composer\Ordering;
use PhpSpec\ObjectBehavior;

class OrderingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Ordering::class);
    }
}
