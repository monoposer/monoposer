<?php

declare(strict_types=1);

namespace Monoposer\Commands;

use Monoposer\Config\PackageConfig;
use Monoposer\Helper\PackageHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class BootstrapCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'bootstrap';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('Link local packages together and install remaining package dependencies')
            ->addOption('production', null, InputOption::VALUE_NONE, 'Install external dependencies matching [glob] to the repo root')
            ->setHelp('This Command allows you to install all packages dependency');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //TODO - link to native dependency
        $isDev = $input->getOption('production') ? true : false;

        $allDirs =  PackageHelper::getAllSubDirs(PackageConfig::getPackageDirPath());
        foreach ($allDirs as  $dir) {
            $path = PackageConfig::getPackageDirPath() . '/' . $dir;
            exec(`cd  ${path} && composer install ` . $isDev ? ' ' : '--no-dev ', $op,  $result);
            if ($result > 0) {
                $output->writeln(`${dir} install dependency fail`);
                $output->writeln($op);
                continue;
            }
        }

        return Command::SUCCESS;
    }
}
