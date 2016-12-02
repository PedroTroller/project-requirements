<?php

namespace Knp\ProjectRequirements\File;

use Knp\ProjectRequirements\Checker;
use Knp\ProjectRequirements\Filesystem;
use Knp\ProjectRequirements\Fixer;

abstract class AbstractFileFixer implements Fixer, Checker
{
    /** @var Filesystem */
    private $project;

    /** @var Filesystem */
    private $lib;

    /**
     * @param Filesystem $project
     * @param Filesystem $lib
     */
    public function __construct(Filesystem $project, Filesystem $lib)
    {
        $this->project = $project;
        $this->lib     = $lib;
    }

    /**
     * {@inheritdoc}
     */
    public static function getPriority()
    {
        self::DEFAULT_PRIORITY;
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        if (false === $this->project->exists($this->getFilename())) {
            return false;
        }

        $real     = $this->project->read($this->getFilename(), Filesystem::FORMAT_TEXT);
        $expected = $this->lib->read($this->getFilename(), Filesystem::FORMAT_TEXT);

        return $real === $expected;
    }

    /**
     * {@inheritdoc}
     */
    public function fix()
    {
        $this->project->write(
            $this->getFilename(),
            $this->lib->read($this->getFilename(), Filesystem::FORMAT_TEXT),
            Filesystem::FORMAT_TEXT
        );
    }

    /**
     * @return string
     */
    abstract protected function getFilename();
}
