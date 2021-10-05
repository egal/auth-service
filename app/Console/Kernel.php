<?php

namespace App\Console;

use App\Console\Commands\DebugCommand;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        DebugCommand::class,
    ];

}
