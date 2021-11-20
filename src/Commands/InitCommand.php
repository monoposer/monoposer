<?php

declare(strict_types=1);

namespace Monoposer\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use Monoposer\Config\ComposerConfig;
use Monoposer\Config\MonoposerConfig;
use Monoposer\Config\PackageConfig;
use Monoposer\Helper\ExtraFromComposer;
use Monoposer\Helper\ExtraToMonoposer;


class InitCommand extends Command
{
    // the name of the command (the part after "monoposer")
    protected static $defaultName = 'init';

    /**
     * extra from composer.json
     * @var ComposerConfig
     */
    private $composerConfig = null;

    /**
     * @var OutputInterface
     */
    private $output = null;

    // The configure() method is called automatically at the end of the command constructor. 
    protected function configure(): void
    {
        $this->setDescription('Create empty monorepo and update package.json')
            ->addOption('independent', 'i', InputOption::VALUE_NONE, 'package mode set')
            ->setHelp('This Command allows you to create empty monorepo repository');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->composerConfig = ExtraFromComposer::getContent();
        // $output->writeln($input->getOption('independent'));
        $this->output = $output;

        if ($this->ensureMonoposerConfig( $input->getOption('independent') ) === false) {
            return Command::FAILURE;
        }

        if ($this->ensurePackagesDir() === false) {
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    /**
     * create monoposer.json as config file
     */
    private function ensureMonoposerConfig(bool $independent = false): bool
    {
        $version = "0.0.0";
        if ($independent) {
            $version = "independent";
        } else if ($this->composerConfig->getVersion()) {
            $version = $this->composerConfig->getVersion();
        }

        $this->output->writeln('<fg=yellow>Create/Update monoposer.json</>');

        $monoposerData = new MonoposerConfig();
        $monoposerData->version = $version;
        $monoposerData->packages = [PackageConfig::PACKAGE_DIR_PATH . "/*"];
        if (ExtraToMonoposer::WriteConfigToFile($monoposerData) === false ) {
            $this->output->writeln('<fg=red>Update monoposer.json Fail</>');
            return false;
        }
        return true;
    }

    /**
     * make packages dir 
     */
    private function ensurePackagesDir(): bool
    {
        $fs = new FileSystem();
        $this->output->writeln("Create packages diretory...");
        if ($fs->exists(PackageConfig::getPackageDirPath()) === false ) {
            try {
                $fs->mkdir(PackageConfig::getPackageDirPath(), 0775);
            } catch (IOExceptionInterface $e) {
                $this->output->writeln("<fg=red>Create package dir error occur</>");
                return false;
            }
        }
        return true;
    }
}
