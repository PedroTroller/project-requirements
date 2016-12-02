<?php

namespace Knp\ProjectRequirements;

interface Operator
{
    const LEVEL_FOSS    = 1;
    const LEVEL_PROJECT = 2;

    const DEFAULT_PRIORITY = 0;

    /**
     * @return int
     */
    public static function getPriority();

    /**
     * @return int
     */
    public function getLevel();

    /**
     * @return bool
     */
    public function isActive();

    /**
     * @return string
     */
    public function getDescription();
}
