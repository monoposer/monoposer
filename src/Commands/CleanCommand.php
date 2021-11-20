<?php
declare(strict_types=1);

namespace Monoposer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class CleanCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'clean';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('Remove the vendor directory from all packages')
            ->addOption('yes', 'y' , InputOption::VALUE_NONE, 'Skip all confirmation prompts')
            ->setHelp('This Command allows you to remove all vendor ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln( $input->getOption('yes'));
        return Command::SUCCESS;
    }
}
