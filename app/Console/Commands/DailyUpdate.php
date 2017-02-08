<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Illuminate\Support\Facades\Mail;
use Log;
use App\timesheet_not_filled;

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
        if(date('N')== 7 || date('N')== 6)
            exit();
        $get_all_manager=DB::table('users')->select('manager_id')->where('manager_id','>','0')->groupBy('manager_id')->lists('manager_id');
        if(count($get_all_manager)>0)
        {

            foreach($get_all_manager as $key=>$value)
            {
                $manager_data=array();
                
                $manager_detail=DB::table('users')->where('user_id',$value)->get();
                $manager_name=$manager_detail[0]->first_name." ".$manager_detail[0]->last_name;

                $manager_data["$manager_name"]=array();
                $get_all_dr=DB::table('users')->select('user_id')->where('manager_id',$value)->lists('user_id');
                $dr_names=array();
                foreach($get_all_dr as $all_dr_key=>$all_dr_value)
                {
                    $user_data=array();
                    $dr_detail=DB::table('users')->where('user_id',$all_dr_value)->get();
                    $get_timesheet_data=DB::table('users')->join('day_times','users.user_id','=','day_times.user_id')->join('add_projects','day_times.project_name','=','add_projects.project_id')->join('project_designations','project_designations.d_id','=','day_times.d_id')->select('users.username','users.first_name','users.last_name','add_projects.project_name','day_times.comments','day_times.d_id','day_times.hrs_locked','add_projects.project_id','project_designations.d_name')->where('day_times.date',$todays_date)->where('day_times.user_id',$all_dr_value)->get();
                    if(count($get_timesheet_data)>=0)
                    {
                        if(count($get_timesheet_data)==0)
                        {
                            $check_timesheet_not_filled=DB::table('timesheet_not_filled')->where('user_id',$all_dr_value)->get();
                            $timesheet_not_filled=new timesheet_not_filled;
                            if(count($check_timesheet_not_filled)>0)
                            {
                                $timesheet_not_filled->where('user_id', $all_dr_value)->increment('count');
                                
                                
                            }
                            else
                            {
                                $timesheet_not_filled->user_id=$all_dr_value;
                                $timesheet_not_filled->count=1;
                                $timesheet_not_filled->save();
                            }
                        }

                        $name=$dr_detail[0]->first_name." ".$dr_detail[0]->last_name;
                        $user_data['name']=$name;
                        array_push($dr_names, $name);
                        $total_hrs_today=DB::table('day_times')->where('user_id',$all_dr_value)
                        ->where('date',$todays_date)->lists('hrs_locked');
                        $total_hrs_today=(json_decode(json_encode($total_hrs_today), true));
                        $user_data['total_hrs_today']=$this->getminutes($total_hrs_today); 
                        $last_updated=DB::table('day_times')->where('user_id',$all_dr_value)
                        ->where('date',$todays_date)->select('updated_at')->latest()->first();
                        if(count($last_updated)==0)
                            $user_data['last_updated']="Not updated today";
                        else
                            $user_data['last_updated']=$last_updated->updated_at;
                        $activity=array();
                        $user_data['user_email']=$dr_detail[0]->username;
                        $user_data['todays_activity']=array();
                        foreach($get_timesheet_data as $data=>$data_value)
                        {

                            $tmp=array();
                            $project_id=$data_value->project_id;
                            $designation_id=$data_value->d_id;

                            $total_estimated_hrs=DB::table('phase_individual_resources')->where('project_id',$project_id)->where('d_id',$designation_id)->SUM('actual_hrs');
                            $total_hrs_to_date=DB::table('day_times')->where('user_id',$all_dr_value)
                            ->where('project_name',$project_id)->where('d_id',$designation_id)->lists('hrs_locked');

                            $total_hrs_to_date=(json_decode(json_encode($total_hrs_to_date), true));
                            $total_hrs_to_date=$this->getminutes($total_hrs_to_date);
                            $project_end_date=DB::table('project_details')->where('project_id',$project_id)->select('p_II_live')->get();
                            if(count($project_end_date)>0)
                                $tmp['project_end_date']=$project_end_date[0]->p_II_live;
                            else
                                $tmp['project_end_date']="not specified";
                            $tmp['project_name']=$data_value->project_name;
                            $tmp['description']=$data_value->comments;
                            $tmp['hrs_locked']=$data_value->hrs_locked;
                            $tmp['total_estimated_hrs']=$total_estimated_hrs;
                            $tmp['total_hrs_to_date']=$total_hrs_to_date;
                            $tmp['designation']=$data_value->d_name;
                 //$todays_activity=array();
                            array_push($user_data['todays_activity'],$tmp);
                        }


                    }

                    array_push($manager_data["$manager_name"], $user_data);

                }
                //foreach()
                $_POST['timesheetdata']["name"]= $manager_data["$manager_name"];
                
                $_POST['timesheetdata']['name']=$manager_name;
                $_POST['timesheetdata']['todays_date']=$todays_date;
                $_POST['timesheetdata']['user_email']=  $manager_detail[0]->username;

                Mail::send('cron/dailyupdate', ['manager_data'=>$manager_data,"dr_names"=>$dr_names], function ($message)
                {

                    $message->from('nilesh.vidhate.prdxn@gmail.com', $_POST['timesheetdata']["name"]);

                    $message->to('vrushali.shelar.prdxn@gmail.com');
                    $message->subject("Direct Report Activities Update for Manager (".$_POST['timesheetdata']['name']." )-ITTT");
                   

                });
                

            }

}


        }

    }



