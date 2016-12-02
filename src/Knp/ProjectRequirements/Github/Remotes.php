<?php

namespace Knp\ProjectRequirements\Github;

class Remotes
{
    /** @var string */
    private $root;

    /**
     * @param string $root
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    /**
     * @return array
     */
    public function getRemotes()
    {
        $remotes = $this->getNames();

        return array_combine(
            $remotes,
            array_map(function ($name) {
                return $this->getUrl($name);
            }, $remotes)
        );
    }

    /**
     * @return string[]
     */
    private function getNames()
    {
        return explode('\n', exec(sprintf('(cd %s; git remote)', $this->root)));
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function getUrl($name)
    {
        return exec(sprintf('(cd %s; git remote get-url %s)', $this->root, $name));
    }
}
