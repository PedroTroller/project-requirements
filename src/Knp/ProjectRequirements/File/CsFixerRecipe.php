<?php

namespace Knp\ProjectRequirements\File;

class CsFixerRecipe extends AbstractFileFixer
{
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
    public function getDescription()
    {
        return 'The php-cs-fixer recipe MUST BE up to date.';
    }

    /**
     * {@inheritdoc}
     */
    protected function getFilename()
    {
        return '.php_cs';
    }
}
