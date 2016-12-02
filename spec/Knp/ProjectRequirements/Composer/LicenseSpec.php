<?php

namespace spec\Knp\ProjectRequirements\Composer;

use Knp\ProjectRequirements\Checker;
use Knp\ProjectRequirements\Composer\License;
use Knp\ProjectRequirements\Filesystem;
use Knp\ProjectRequirements\Fixer;
use PhpSpec\ObjectBehavior;

class LicenseSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(License::class);
    }

    function it_is_a_checker()
    {
        $this->shouldHaveType(Checker::class);
    }

    function it_is_a_fixer()
    {
        $this->shouldHaveType(Fixer::class);
    }

    function it_is_active()
    {
        $this->isActive()->shouldReturn(true);
    }

    function it_can_check_if_there_is_a_license($filesystem)
    {
        $filesystem->read('composer.json', Filesystem::FORMAT_JSON)->willReturn([]);

        $this->check()->shouldReturn(false);

        $filesystem->read('composer.json', Filesystem::FORMAT_JSON)->willReturn(['license' => '']);

        $this->check()->shouldReturn(false);

        $filesystem->read('composer.json', Filesystem::FORMAT_JSON)->willReturn(['license' => null]);

        $this->check()->shouldReturn(false);

        $filesystem->read('composer.json', Filesystem::FORMAT_JSON)->willReturn(['license' => 'MIT']);

        $this->check()->shouldReturn(true);

        $filesystem->read('composer.json', Filesystem::FORMAT_JSON)->willReturn(['license' => 'PROPRIETARY']);

        $this->check()->shouldReturn(true);
    }

    function it_can_fix_missing_license($filesystem)
    {
        $filesystem
            ->read('composer.json', Filesystem::FORMAT_JSON)
            ->willReturn(['license' => ''])
        ;

        $filesystem
            ->write('composer.json', ['license' => 'MIT'], Filesystem::FORMAT_JSON)
            ->shouldBeCalled()
        ;

        $this->fix();
    }
}
