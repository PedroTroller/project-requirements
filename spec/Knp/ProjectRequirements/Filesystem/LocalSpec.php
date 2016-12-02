<?php

namespace spec\Knp\ProjectRequirements\Filesystem;

use Knp\ProjectRequirements\Filesystem;
use Knp\ProjectRequirements\Filesystem\Local;
use PhpSpec\ObjectBehavior;

class LocalSpec extends ObjectBehavior
{
    private $path;

    function let()
    {
        $this->path = sprintf('%s/%s', sys_get_temp_dir(), uniqid());
        mkdir($this->path);

        $this->beConstructedWith($this->path);
    }

    function letGo()
    {
        foreach (glob(sprintf('%s/*', $this->path)) as $file) {
            unlink($file);
        }

        rmdir($this->path);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Local::class);
    }

    function it_creates_a_file_from_an_array()
    {
        $this->write('file.json', ['foo', 'bar', 'baz'], Filesystem::FORMAT_JSON);

        $json = <<<'JSON'
[
    "foo",
    "bar",
    "baz"
]
JSON;

        $this->read('file.json', Filesystem::FORMAT_TEXT)->shouldReturn($json);
        $this->read('file.json', Filesystem::FORMAT_JSON)->shouldReturn(['foo', 'bar', 'baz']);

        expect(file_get_contents(sprintf('%s/file.json', $this->path)))->toBe($json);
    }

    function it_creates_a_file_from_a_string()
    {
        $this->write('file.txt', 'foo', Filesystem::FORMAT_TEXT);

        expect(file_get_contents(sprintf('%s/file.txt', $this->path)))->toBe('foo');
    }
}
