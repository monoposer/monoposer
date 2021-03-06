<?php
declare(strict_types=1);

namespace Monoposer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class ChangedCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'changed';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('List local packages that have changed since the last tagged release')
            ->setHelp('This Command allows you to create a user ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('hello ');
        $output->writeln('world');

        return Command::SUCCESS;
    }
}
