<?php

namespace spec\Knp\ProjectRequirements\Github;

use Exception;
use Knp\ProjectRequirements\Github\Remotes;
use PhpSpec\ObjectBehavior;

class RemotesSpec extends ObjectBehavior
{
    function let()
    {
        $root = realpath(sprintf('%s/../../../..', __DIR__));

        $this->beConstructedWith($root);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Remotes::class);
    }

    function it_returns_all_remotes()
    {
        $array = $this->getRemotes()->getWrappedObject();

        if (count($array) === 0) {
            throw new Exception('Your git project have to have at least one remote.');
        }

        foreach ($array as $remote => $url) {
            expect($remote)->toBeString();
            expect($url)->toBeString();
        }
    }
}
