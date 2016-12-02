<?php

namespace Knp\ProjectRequirements\Application\Command;

use Knp\ProjectRequirements\Checker;
use Knp\ProjectRequirements\Operator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Check extends Base
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        parent::configure();

        $this
            ->setName('check')
            ->setDescription('Check if the current application respects the standards')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $level   = Operator::LEVEL_PROJECT;
        $success = true;

        if ($input->getOption('foss')) {
            $level = Operator::LEVEL_FOSS;
        }

        foreach ($this->getOperators() as $operator) {
            if (false === $operator instanceof Checker) {
                continue;
            }

            if ($operator->getLevel() < $level) {
                continue;
            }

            if (false === $operator->isActive()) {
                continue;
            }

            $check   = $operator->check();
            $success = !$success || $check;

            $message = $this
                ->getHelperSet()
                ->get('formatter')
                ->formatBlock(
                    $operator->getDescription(),
                    $check ? 'info' : 'error',
                    false === $check
                )
            ;

            $output->writeln($message);
        }

        return $success ? 0 : 1;
    }
}
