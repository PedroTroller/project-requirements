<?php

namespace Knp\ProjectRequirements\Application\Command;

use Knp\ProjectRequirements\DependencyInjection\Container\Builder;
use Knp\ProjectRequirements\Operator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

abstract class Base extends Command
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this
            ->addOption('foss', null, InputOption::VALUE_NONE, 'Requirements for free open-source project')
            ->addOption('project', null, InputOption::VALUE_NONE, 'Requirements for other project (default)')
        ;
    }

    /**
     * @return Operator[]
     */
    protected function getOperators()
    {
        $container  = $this->getContainer();
        $operators  = $container['operators'];
        $priorities = array_map(function (Operator $operator) {
            $class = get_class($operator);
            $class::getPriority();
        }, $operators);

        array_multisort($priorities, SORT_DESC, SORT_NUMERIC, $operators);

        return $operators;
    }

    /**
     * @return \Knp\ProjectRequirements\DependencyInjection\Container
     */
    private function getContainer()
    {
        return Builder::build();
    }
}
