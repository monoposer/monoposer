<?php
declare(strict_types=1);

namespace Monoposer\Commands;

use Monoposer\Config\PackageConfig;
use Monoposer\Helper\PackageHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class SplitCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'split';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('Diff all packages or a single package since the last release')
            ->addOption( 'exclude', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Exclude one or more package from the list' )
            ->setHelp('This Command allows you to show all packages ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $allDirs =  PackageHelper::getAllSubDirs(PackageConfig::getPackageDirPath());
        $excludeDirs = (array)$input->getOption('exclude');
        $output->write(json_encode( array_values( array_diff( $allDirs, $excludeDirs ) ) ));
        return Command::SUCCESS;
    }
}
