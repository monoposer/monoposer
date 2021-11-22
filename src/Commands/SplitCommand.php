<?php
declare(strict_types=1);

namespace Monoposer\Commands;

use Monoposer\Config\PackageConfig;
use Monoposer\Helper\ConfigHelper;
use Monoposer\Helper\PackageHelper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class SplitCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'split';

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure()
    {
        $this->setDescription('resolve all packages to single repository')
            ->addArgument('repos', InputArgument::IS_ARRAY, 'need split repos')
            ->setHelp('Resolving configuration...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = ConfigHelper::getConfig();
        if( $config->pkgName === '' ) {
            return Command::FAILURE;
        }
        $output->writeln("clone repository...");
        $workingDir = getcwd();
        $tempDir = sys_get_temp_dir() . '/monoposer';
        $command = 'git clone -- https://'. $config->accessToken . '@' . $config->getRepositoryName() . ' ' . $tempDir;
        exec( $command);
        // if( $resultCode === 1 ) {
        //     $output->writeln('<fg=red>git clone failed</>');
        //     return Command::FAILURE;
        // }
        //copy origin files
        $fs = new Filesystem();
        if( $fs->exists( PackageConfig::getPackageDirPath() . '/'  . $config->pkgName ) === false ) {
                $output->writeln('<fg=red>file is missing</>');
                return Command::FAILURE;
        }
        $cpCommand = sprintf('cp -ra %s %s', PackageConfig::getPackageDirPath() . '/'  . $config->pkgName, $tempDir );
        exec( $cpCommand, $output, $resultCode );
        $curCommitMsg = $this->getCommitMessage($config->commitHash);

        chdir($tempDir);
        // git ops ...
        exec( 'git status --porcelain', $files );
        if($files) {
            $output->writeln('commiting...');
            exec("git add .");
            exec("git commit --message " . $curCommitMsg);
            exec("git push --quiet origin" . $config->branch);
        } else {
            $output->writeln("$config->pkgName has no file chaned");
            return Command::SUCCESS;
        }
        if($config->tag) {
            $output->writeln("push new tag ...");
            $commandLine = sprintf('git tag %s -m "%s"', $config->tag, "push tag: $config->tag");
            exec($commandLine);
            exec("git push --quiet origin $config->tag");
        }
        chdir($workingDir);
        return Command::SUCCESS;
    }

    private function getCommitMessage( string $commitHash ): string {
        exec("git show -s --format=%B $commitHash", $out);
        return $out[0] ?? "";
    }
}



