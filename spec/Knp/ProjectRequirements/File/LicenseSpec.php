<?php

namespace spec\Knp\ProjectRequirements\File;

use Knp\ProjectRequirements\Checker;
use Knp\ProjectRequirements\File\License;
use Knp\ProjectRequirements\Filesystem;
use Knp\ProjectRequirements\Fixer;
use PhpSpec\ObjectBehavior;

class LicenseSpec extends ObjectBehavior
{
    function let(Filesystem $project, Filesystem $lib)
    {
        $this->beConstructedWith($project, $lib);
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

    function it_can_check_if_the_file_is_up_to_date($project, $lib)
    {
        $project->exists('LICENSE')->willReturn(false);

        $this->check()->shouldReturn(false);

        $project->exists('LICENSE')->willReturn(true);

        $project->read('LICENSE', Filesystem::FORMAT_TEXT)->willReturn('foo');
        $lib->read('LICENSE', Filesystem::FORMAT_TEXT)->willReturn('bar');

        $this->check()->shouldReturn(false);

        $project->read('LICENSE', Filesystem::FORMAT_TEXT)->willReturn('foo');
        $lib->read('LICENSE', Filesystem::FORMAT_TEXT)->willReturn('foo');

        $this->check()->shouldReturn(true);
    }

    function it_updates_the_license($project, $lib)
    {
        $lib->read('LICENSE', Filesystem::FORMAT_TEXT)->willReturn('foo');
        $project->write('LICENSE', 'foo', Filesystem::FORMAT_TEXT)->shouldBeCalled();

        $this->fix();
    }
}
