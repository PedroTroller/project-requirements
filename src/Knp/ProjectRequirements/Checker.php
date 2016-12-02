<?php

namespace Knp\ProjectRequirements;

interface Checker extends Operator
{
    /**
     * @return bool
     */
    public function check();
}
