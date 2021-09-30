<?php

namespace Commands;

use Commands\HelloWorldCommand;
use LegoCue\Framework\Kernel;

class Console extends Kernel
{
    protected $commands = [
        HelloWorldCommand::class,
    ];
}
