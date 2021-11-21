<?php
declare(strict_types=1);

namespace Monoposer\Commands;

use Monoposer\Commands\AddCommand;
use Monoposer\Commands\BootstrapCommand;
use Monoposer\Commands\ChangedCommand;
use Monoposer\Commands\CleanCommand;
use Monoposer\Commands\CreateCommand;
use Monoposer\Commands\DiffCommand;
use Monoposer\Commands\InitCommand;
use Monoposer\Commands\ListCommand;
use Monoposer\Commands\VersionCommand;
use LegoCue\Framework\Kernel;

class Console extends Kernel
{
    protected $commands = [
        AddCommand::class,
        BootstrapCommand::class,
        ChangedCommand::class,
        CleanCommand::class,
        CreateCommand::class,
        DiffCommand::class,
        InitCommand::class,
        ListCommand::class,
        VersionCommand::class
    ];
}
