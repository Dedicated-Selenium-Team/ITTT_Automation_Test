<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Mail;
use Log;

class escalation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:escalation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

 public function getminutes($date_array)
{
  $time = new \DateTime('00:00');
  foreach($date_array as $new_date)
  {


    $new_date = number_format((float)$new_date,2);
    $time->add(new \DateInterval("PT".str_replace(".","H",$new_date."M")));  
  }
  $interval = $time->diff(new \DateTime('00:00'));
  $dates=$interval->d;
  return ($dates*24)+$interval->h.':'.sprintf("%'.02d\n",$interval->i);
}
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
$todays_date=date('Y-m-d');
        $escalation_report=array();
        $escalation_report['timesheet_for_today']=DB::table('day_times')->where('date',$todays_date)->distinct('user_id')->count('user_id');
        $escalation_report['total_user']=DB::table('users')->count();
        $escalation_report['efficient_user_count']=0;
        $escalation_report['beyond_estimate']=0;
        if($escalation_report['timesheet_for_today']>0)
        {
            $todays_timesheet_user=DB::table('day_times')->where('date',$todays_date)->groupBy('user_id')->select('user_id')->get();
            foreach($todays_timesheet_user as $key=>$value)
            {
                $total_hrs_today=DB::table('day_times')->where('user_id',$value->user_id)
->where('date',$todays_date)->lists('hrs_locked');
        $total_hrs_today=(json_decode(json_encode($total_hrs_today), true));
                 if($this->getminutes($total_hrs_today)>6)
                    $escalation_report['efficient_user_count']++;

            }
        
        }
        $total_projects=DB::table('add_projects')->where('status_id','<>','4')->where('is_deleted','0')->where('is_archived','0')->get();
        foreach($total_projects as $key=>$value)
        {
            $project_total_hrs=DB::table('day_times')->where('project_name',$value->project_id)->lists('hrs_locked');
            $project_estimated_hrs=DB::table('phase_individual_resources')->where('project_id',$value->project_id)->lists('actual_hrs');
         $project_total_hrs=(json_decode(json_encode( $project_total_hrs), true));
         $project_estimated_hrs=(json_decode(json_encode( $project_estimated_hrs), true));
                 if($this->getminutes( $project_total_hrs)>$this->getminutes( $project_estimated_hrs))
                    $escalation_report['beyond_estimate']++;
        }


        Mail::send('cron/escalation', ['escalation_report'=>$escalation_report], function ($message)
        {
           
            $message->from('nilesh.vidhate.prdxn@gmail.com', 'ITTT Admin');

            $message->to('vrushali.shelar.prdxn@gmail.com');
            $message->subject( "ITTT Daily Escalation report");
           


        });

        
    }
        
    
}
