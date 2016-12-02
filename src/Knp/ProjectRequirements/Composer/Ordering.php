<?php

namespace Knp\ProjectRequirements\Composer;

use Knp\ProjectRequirements\Checker;
use Knp\ProjectRequirements\Filesystem;
use Knp\ProjectRequirements\Fixer;

class Ordering implements Checker, Fixer
{
    /** @var string[] */
    private $order = [
        'name',
        'description',
        'version',
        'type',
        'keywords',
        'homepage',
        'time',
        'license',
        'authors',
        'support',
        'Package links',
        'require',
        'require-dev',
        'conflict',
        'replace',
        'provide',
        'suggest',
        'autoload',
        'autoload-dev',
        'include-path',
        'target-dir',
        'minimum-stability',
        'prefer-stable',
        'repositories',
        'config',
        'scripts',
        'extra',
        'bin',
        'archive',
        'non-feature-branches',
    ];

    /** @var Filesystem */
    private $project;

    /**
     * @param Filesystem $project
     */
    public function __construct(Filesystem $project)
    {
        $this->project = $project;
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
        $composer = $this->project->read('composer.json', Filesystem::FORMAT_JSON);

        return $composer === $this->getOrderedConfig();
    }

    /**
     * {@inheritdoc}
     */
    public function fix()
    {
        $this->project->write(
            'composer.json',
            $this->getOrderedConfig(),
            Filesystem::FORMAT_JSON
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'The composer.json file MUST BE ordered';
    }

    /**
     * @return array
     */
    private function getOrderedConfig()
    {
        $composer = $this->project->read('composer.json', Filesystem::FORMAT_JSON);
        $result   = [];

        foreach ($this->order as $key) {
            if (false === array_key_exists($key, $composer)) {
                continue;
            }

            $result[$key] = $composer[$key];
            unset($composer[$key]);
        }

        foreach ($composer as $key => $value) {
            $result[$key] = $composer[$key];
        }

        return $result;
    }
}
