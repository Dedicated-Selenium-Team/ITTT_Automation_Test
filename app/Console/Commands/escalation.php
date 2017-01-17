<?php

namespace App\Commands;

use App\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;

class escalation extends Command implements SelfHandling
{
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        $todays_date=date('Y-m-d');
        $timesheet_for_today=DB::table('day_times')->distinct('user_id')
        ->where('date',$todays_date)->count();
        echo $timesheet_for_today;
    }
}
