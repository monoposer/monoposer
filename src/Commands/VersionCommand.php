<?php
declare(strict_types=1);

namespace Monoposer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class VersionCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'version';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('Bump version of packages changed since the last release.')
            ->addArgument('bump', InputArgument::REQUIRED,'Bump version of packages')
            ->addOption( 'yes', 'y', InputOption::VALUE_NONE, '' )
            ->setHelp('This Command allows you to create a version ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln($input->getArgument('bump'));
        return Command::SUCCESS;
    }
}
