<?php

namespace Knp\ProjectRequirements\Composer;

use Knp\ProjectRequirements\Checker;
use Knp\ProjectRequirements\Filesystem;
use Knp\ProjectRequirements\Fixer;

class License implements Checker, Fixer
{
    /** @var Filesystem */
    private $filesystem;

    /**
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * {@inheritdoc}
     */
    public static function getPriority()
    {
        return Ordering::getPriority() - 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getLevel()
    {
        return self::LEVEL_PROJECT;
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
        $composer = $this->filesystem->read('composer.json', Filesystem::FORMAT_JSON);

        if (false === array_key_exists('license', $composer)) {
            return false;
        }

        return false === empty($composer['license']);
    }

    /**
     * {@inheritdoc}
     */
    public function fix()
    {
        if (true === $this->check()) {
            return;
        }

        $composer = $this->filesystem->read('composer.json', Filesystem::FORMAT_JSON);

        $composer['license'] = 'MIT';

        $this->filesystem->write('composer.json', $composer, Filesystem::FORMAT_JSON);
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'The license MUST BE setted';
    }
}
