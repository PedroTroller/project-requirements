<?php

namespace spec\Knp\ProjectRequirements\File;

use Knp\ProjectRequirements\Checker;
use Knp\ProjectRequirements\File\CsFixerRecipe;
use Knp\ProjectRequirements\Filesystem;
use Knp\ProjectRequirements\Fixer;
use PhpSpec\ObjectBehavior;

class CsFixerRecipeSpec extends ObjectBehavior
{
    function let(Filesystem $project, Filesystem $lib)
    {
        $this->beConstructedWith($project, $lib);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(CsFixerRecipe::class);
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
        $project->exists('.php_cs')->willReturn(false);

        $this->check()->shouldReturn(false);

        $project->exists('.php_cs')->willReturn(true);

        $project->read('.php_cs', Filesystem::FORMAT_TEXT)->willReturn('foo');
        $lib->read('.php_cs', Filesystem::FORMAT_TEXT)->willReturn('bar');

        $this->check()->shouldReturn(false);

        $project->read('.php_cs', Filesystem::FORMAT_TEXT)->willReturn('foo');
        $lib->read('.php_cs', Filesystem::FORMAT_TEXT)->willReturn('foo');

        $this->check()->shouldReturn(true);
    }

    function it_updates_the_php_cs_recipe($project, $lib)
    {
        $lib->read('.php_cs', Filesystem::FORMAT_TEXT)->willReturn('foo');
        $project->write('.php_cs', 'foo', Filesystem::FORMAT_TEXT)->shouldBeCalled();

        $this->fix();
    }
}
