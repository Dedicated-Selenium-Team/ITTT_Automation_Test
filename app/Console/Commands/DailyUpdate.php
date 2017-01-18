<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Mail;
use Log;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:crone';

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
        $users=DB::table('users')->join('self_projects','users.user_id','=','self_projects.user_id')->distinct('user_id')->select('users.user_id','users.username')->get();
        if(count($users)>0)
        {
            foreach($users as $key=>$value)
            {
                $user_data=array();
                $get_timesheet_data=DB::table('users')->join('day_times','users.user_id','=','day_times.user_id')->join('add_projects','day_times.project_name','=','add_projects.project_id')->join('project_designations','project_designations.d_id','=','day_times.d_id')->select('users.username','users.first_name','users.last_name','add_projects.project_name','day_times.comments','day_times.d_id','day_times.hrs_locked','add_projects.project_id','project_designations.d_name')->where('day_times.date',$todays_date)->where('day_times.user_id',$value->user_id)->get();
                if(count($get_timesheet_data)>0)
                {
                    $name=$get_timesheet_data[0]->first_name." ".$get_timesheet_data[0]->last_name;
                    $user_data['name']=$name;
                    $total_hrs_today=DB::table('day_times')->where('user_id',$value->user_id)
                    ->where('date',$todays_date)->lists('hrs_locked');
                    $total_hrs_today=(json_decode(json_encode($total_hrs_today), true));
                    $user_data['total_hrs_today']=$this->getminutes($total_hrs_today); 
                    $last_updated=DB::table('day_times')->where('user_id',$value->user_id)
                    ->where('date',$todays_date)->select('updated_at')->latest()->first();
                    $user_data['last_updated']=$last_updated->updated_at;
                    $activity=array();
                    $user_data['user_email']=$value->username;
                    $user_data['todays_activity']=array();
                    foreach($get_timesheet_data as $data=>$data_value)
                    {

                        $tmp=array();
                        $project_id=$data_value->project_id;
                        $designation_id=$data_value->d_id;

                        $total_estimated_hrs=DB::table('phase_individual_resources')->where('project_id',$project_id)->where('d_id',$designation_id)->SUM('actual_hrs');
                        $total_hrs_to_date=DB::table('day_times')->where('user_id',$value->user_id)
                        ->where('project_name',$project_id)->where('d_id',$designation_id)->lists('hrs_locked');

                        $total_hrs_to_date=(json_decode(json_encode($total_hrs_to_date), true));
                        $total_hrs_to_date=$this->getminutes($total_hrs_to_date);

                        $tmp['project_name']=$data_value->project_name;
                        $tmp['description']=$data_value->comments;
                        $tmp['hrs_locked']=$data_value->hrs_locked;
                        $tmp['total_estimated_hrs']=$total_estimated_hrs;
                        $tmp['total_hrs_to_date']=$total_hrs_to_date;
                        $tmp['designation']=$data_value->d_name;
                 //$todays_activity=array();
                        array_push($user_data['todays_activity'],$tmp);
                    }
                    $_POST['timesheetdata']['name']= $user_data['name'];
                    $_POST['timesheetdata']=$user_data;
                    $_POST['timesheetdata']['todays_date']=$todays_date;
                    $_POST['timesheetdata']['user_email']=$user_data['user_email'];
                    $repeated_task=array();
                    foreach($user_data['todays_activity'] as $key=>$value)
                    {
                        if(!array_key_exists($value['project_name']."_".$value['designation'],$repeated_task))
                        {
                            $repeated_task[$value['project_name']."_".$value['designation']]=array();
                        }
                        array_push($repeated_task[$value['project_name']."_".$value['designation']],$key);
                    }

                    foreach($repeated_task as $key=>$value)
                    {
                        
                        foreach($value as $data_key=>$key_value)
                        {
                            $user_data['todays_activity'][$value[0]]['description']=json_encode($user_data['todays_activity'][$value[0]]['description']);
                            $user_data['todays_activity'][$value[0]]['description']=str_replace('\r\n', '<br>', $user_data['todays_activity'][$value[0]]['description']);
                             $user_data['todays_activity'][$value[0]]['description']=str_replace('"', '', $user_data['todays_activity'][$value[0]]['description']);
                            if($data_key>0)
                            {
                                $task_key=$value[0];

 $user_data['todays_activity'][$key_value]['description']=json_encode($user_data['todays_activity'][$key_value]['description']);
                            $user_data['todays_activity'][$key_value]['description']=str_replace('\r\n', '<br>', $user_data['todays_activity'][$key_value]['description']);
$user_data['todays_activity'][$key_value]['description']=str_replace('"', '', $user_data['todays_activity'][$key_value]['description']);
                                $user_data['todays_activity'][$task_key]['description']
                                =$user_data['todays_activity'][$task_key]['description']."<br>".$user_data['todays_activity'][$key_value]['description'];
                                $user_data['todays_activity'][$task_key]['hrs_locked']=$this->getminutes(array($user_data['todays_activity'][$task_key]['hrs_locked'],$user_data['todays_activity'][$key_value]['hrs_locked']));
                                unset($user_data['todays_activity'][$key_value]);

                            }


                        }


                    }


                    Mail::send('cron/dailyupdate', ['user_data'=>$user_data], function ($message)
                    {

                        $message->from('nilesh.vidhate.prdxn@gmail.com', $_POST['timesheetdata']["name"]);

                        $message->to('chetan.kadam.prdxn@gmail.com');
                        $message->subject( $_POST['timesheetdata']['name']." | Daily Update (ITTT Report)");
                        $message->replyTo($_POST['timesheetdata']['user_email'], $name = $_POST['timesheetdata']["name"]);



                    });
                }
            }

        }

    }
        
    
}
