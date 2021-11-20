<?php

declare(strict_types=1);

namespace Monoposer\Commands;

use Monoposer\Config\PackageConfig;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'add';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('Add a single dependency to matched packages')
            ->addArgument('pkg', InputArgument::REQUIRED, 'Package name to add as a dependency')
            ->addOption('scope', null, InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Optional package directory globs to match', [])
            ->addOption('dev', 'D', InputOption::VALUE_NONE, 'Save to devDependencies')
            ->setHelp('This Command allows you to add a dependency ...');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $pkg = $input->getArgument('pkg');
        // check pkg valid
        if($this->hasPackage($pkg) === false) {
            $output->writeln("<fg=red>Pkg not satisfiable or Not Found</>");
            return Command::FAILURE;
        }

        // check dir valid
        $dirs = (array)$input->getOption('scope');
        $allDirs =  $this->getAllSubDirs(PackageConfig::getPackageDirPath());
        if(empty($dirs)) {
            $dirs = $allDirs;
        } else {
            $dirs = array_filter($dirs, function($dir) use ($allDirs) {
                return in_array( $dir, $allDirs );
            });
        }
        $this->requirePackage( $pkg, $dirs, $input->getOption('dev') );
        return Command::SUCCESS;
    }


    private function hasPackage( string  $pkgName ) : bool{
        exec( 'composer search ' . $pkgName . ' -N', $op, $resultCode );
        if( $resultCode > 0 || empty($op) ) {
            return false;
        }
        return true;
    }

    private function getAllSubDirs( string $dirPath ): array {
        if( !is_dir($dirPath) ) {
            return []; 
        } 
        $arr = [];
        foreach ( scandir($dirPath) as $v ) {
            if( $v != '.' && $v != '..' ) {
                $arr[] = $v;
            }
        }
        return $arr;
    }

    /**
     * install dependency to matched package
     * @param string $pkg
     * @param array $dirs
     * @param bool $isDev
     * @return void
     */
    private function requirePackage( string $pkg, array $dirs, bool $isDev = false ) {

        foreach ($dirs as  $dir) {
            $path = PackageConfig::getPackageDirPath() . '/' . $dir; //TODO
            exec( `cd  ${path} && composer ` . $isDev ? 'require-dev ' : 'require '. $pkg, $op , $result);
            if($result > 0) {
                break;
            }
        }

    }
}
