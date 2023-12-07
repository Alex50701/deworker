<?php

namespace App\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends \Symfony\Component\Console\Command\Command
{
    protected function configure(): void
    {
        $this
            ->setName('hello')
            ->setDescription('Test decription');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Hello!</info>');
        return 0;
    }
}
