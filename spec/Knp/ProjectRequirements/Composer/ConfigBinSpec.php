<?php

namespace spec\Knp\ProjectRequirements\Composer;

use Knp\ProjectRequirements\Checker;
use Knp\ProjectRequirements\Composer\ConfigBin;
use Knp\ProjectRequirements\Filesystem;
use Knp\ProjectRequirements\Fixer;
use PhpSpec\ObjectBehavior;

class ConfigBinSpec extends ObjectBehavior
{
    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ConfigBin::class);
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

    function it_can_check_if_the_bin_dir_is_setted($filesystem)
    {
        $filesystem->read('composer.json', Filesystem::FORMAT_JSON)->willReturn([]);

        $this->check()->shouldReturn(false);

        $filesystem->read('composer.json', Filesystem::FORMAT_JSON)->willReturn(['config' => ['bin-dir' => 'vendor/bin']]);

        $this->check()->shouldReturn(false);

        $filesystem->read('composer.json', Filesystem::FORMAT_JSON)->willReturn(['config' => ['bin-dir' => 'bin']]);

        $this->check()->shouldReturn(true);
    }

    function it_can_fix_missing_config($filesystem)
    {
        $filesystem
            ->read('composer.json', Filesystem::FORMAT_JSON)
            ->willReturn(['other' => 'config'])
        ;

        $filesystem
            ->write('composer.json', ['other' => 'config', 'config' => ['bin-dir' => 'bin']], Filesystem::FORMAT_JSON)
            ->shouldBeCalled()
        ;

        $this->fix();
    }
}
