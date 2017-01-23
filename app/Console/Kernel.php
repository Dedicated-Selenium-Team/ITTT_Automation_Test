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
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\DailyUpdate::class,
        \App\Console\Commands\escalation::class,
         \App\Console\Commands\PmReport::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('inspire')
                 ->hourly();
        $schedule->command('command:crone')
                 ->dailyAt('19:30');
        $schedule->command('command:escalation')
                ->dailyAt('19:30');
        $schedule->command('command:PmReport')
                 ->dailyAt('19:30');
        $schedule->command('command:slack_notification')
                 ->daily();
    }
}
