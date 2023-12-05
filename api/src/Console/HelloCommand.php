<?php

namespace App\Console;

class HelloCommand extends \Symfony\Component\Console\Command\Command
{
    protected function configure():void
    {
        $this
            ->setName('hello')
            ->setDescription('Test decription');
    }

    protected function execute(\Symfony\Component\Console\Input\InputInterface $input, \Symfony\Component\Console\Output\OutputInterface $output):int
    {
        $output->writeln('<info>Hello!</info>');
        return 0;
    }
}