<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App\Console;

use App\Console\Commands\DebugCommand;
use App\Console\Commands\RegisterServiceCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    /**
     * Команды Artisan, предоставляемые вашим приложением.
     *
     * @var array
     */
    protected $commands = [
        DebugCommand::class,
        RegisterServiceCommand::class
    ];

    /**
     * Определение расписания команд приложения.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }

}
