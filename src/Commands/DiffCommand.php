<?php
declare(strict_types=1);

namespace Monoposer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class DiffCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'diff';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('Diff all packages or a single package since the last release')
            ->addArgument( 'pkgName', InputArgument::REQUIRED, 'An optional package name to filter the diff output' )
            ->setHelp('This Command allows you to diff a single package ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('hello ');
        $output->writeln('world');

        return Command::SUCCESS;
    }
}
