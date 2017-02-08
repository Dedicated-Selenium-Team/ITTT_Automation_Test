<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Mail;
class Slack_notification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:slack_notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify on slack it timesheet is not filled yesterday';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
   {
    $todays_date=date('Y-m-d');
 if(date('N')== 0 || date('N')== 6)
exit();
$text="*Users who did not filled timesheet yesterday:*\n";
if(date('N')== 1)
{
$todays_date=date('Y-m-d',strtotime("-3 days"));
$text="*Users who did not filled timesheet on Friday:*\n";
}
$timesheetuser_for_today= DB::table('day_times')->distinct('user_id')->where('date',$todays_date)->select('user_id')->get();
        $user_array=array();
        foreach($timesheetuser_for_today as $key=>$value)
            array_push($user_array,$value->user_id);
$timesheet_not_submitted = DB::table('users')->
whereNotIn('user_id', $user_array)->select('first_name','last_name')->get();

foreach($timesheet_not_submitted as $key=>$value)
$text.=strtoupper($value->first_name)." ".strtoupper($value->last_name)."\n";
$params=array("text"=> $text);
    $params= json_encode($params);
    
$url="https://hooks.slack.com/services/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";
$ch = \curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $params);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );

   }
}
