<?php

namespace spec\Knp\ProjectRequirements\Github;

use Knp\ProjectRequirements\Github\InformationProvider;
use PhpSpec\ObjectBehavior;

class InformationProviderSpec extends ObjectBehavior
{
    /** @var string */
    private $github_https = 'https://github.com/PedroTroller/project-requirements.git';

    /** @var string */
    private $github_ssh = 'git@github.com:PedroTroller/project-requirements.git';

    function it_is_initializable()
    {
        $this->beConstructedWith($this->github_https);

        $this->shouldHaveType(InformationProvider::class);
    }

    function it_can_extract_informations_form_https_github_link()
    {
        $this->beConstructedWith($this->github_https);

        $this->getSource()->shouldReturn('github');
        $this->getOrganisation()->shouldReturn('PedroTroller');
        $this->getProject()->shouldReturn('project-requirements');
    }

    function it_can_extract_informations_form_ssh_github_link()
    {
        $this->beConstructedWith($this->github_ssh);

        $this->getSource()->shouldReturn('github');
        $this->getOrganisation()->shouldReturn('PedroTroller');
        $this->getProject()->shouldReturn('project-requirements');
    }
}
