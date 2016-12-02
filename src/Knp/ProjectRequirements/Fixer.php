<?php

namespace Knp\ProjectRequirements;

interface Fixer extends Operator
{
    /**
     * @return bool
     */
    public function fix();
}
