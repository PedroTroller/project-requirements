<?php

namespace Knp\ProjectRequirements\File;

class License extends AbstractFileFixer
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
        return 'The project license MUST BE up to date.';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFilename()
    {
        return 'LICENSE';
    }
}
