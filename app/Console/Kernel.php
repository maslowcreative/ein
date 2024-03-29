<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('plans:expire')
                  ->dailyAt('00:10');
         $schedule->command('plan:balance-budget')
                 ->timezone('Australia/Sydney')
                 ->dailyAt('05:00');

         $schedule->command('claims:auto-approve')
                  ->timezone('Australia/Sydney')
                  ->dailyAt('12:30');

         $schedule->command('claims:auto-approve')
                ->timezone('Australia/Sydney')
                ->dailyAt('17:30');


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
