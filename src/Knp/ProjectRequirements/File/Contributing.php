<?php

namespace Knp\ProjectRequirements\File;

class Contributing extends AbstractFileFixer
{
    /**
     * {@inheritdoc}
     */
    public function getLevel()
    {
        return self::LEVEL_FOSS;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return 'The project contribution notice MUST BE up to date.';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFilename()
    {
        return 'CONTRIBUTING.md';
    }
}
