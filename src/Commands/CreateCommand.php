<?php

declare(strict_types=1);

namespace Monoposer\Commands;

use Monoposer\Config\PackageConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class CreateCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'create';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('Create n new monoposer package')
            ->addArgument('name', InputArgument::REQUIRED, 'The package name (including scope), which must be locally unique _and_ publicly available')
            ->addArgument('loc', InputArgument::OPTIONAL, 'A custom package location, defaulting to the first configured package location')
            ->setHelp('This Command allows you to create a pacakge ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fs = new Filesystem();
        $path = PackageConfig::getPackageDirPath() . '/' . $input->getArgument('name');
        // file had created
        if($fs->exists( $path )) {
            return Command::SUCCESS;
        }
        try {
            $fs->mkdir( $path, 0775 );
        } catch (IOExceptionInterface $e) {
            $output->writeln('<fg=red>Make package dir failed</>');
            return Command::FAILURE;
        }
        exec( `cd ${path} && composer init `, $op, $resultCode ); //TODO
        if($resultCode > 0){
            return Command::FAILURE;
        }
        //$output->writeln($input->getArgument('loc'));
        return Command::SUCCESS;
    }
}
