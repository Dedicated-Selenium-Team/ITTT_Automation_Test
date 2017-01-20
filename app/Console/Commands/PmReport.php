<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class PmReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:PmReport';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show Report For Project Manager';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      
/*Hi [Project Manager],

The following time was logged for projects that you're assigned to as Project Manager.

Project Name: xxx
Team-members that logged time today against this project: [List names]
Total time logged TODAY ONLY (all designations) for this project (actuals): x hours
Total time logged to-date (all designations) for this project (actuals): x hours
Total estimate (all designations) for this project (not incl. warranty): x hours
*/
$all_pm_user_id=DB::table('self_projects')->join('add_projects','self_projects.project_id','=','add_projects.project_id')->where('self_projects.designation_id','1')->
        where('add_projects.status_id','<>','4')->
        where('add_projects.is_deleted','0')->
        where('add_projects.is_archived','0')->select('self_projects.user_id')->distinct('self_projects.user_id')->get();
        $todays_date=date('Y-m-d');
        
        foreach($all_pm_user_id as $key=>$value)
        {
            $pm_data=array();
            $my_projects=DB::table('self_projects')->join('add_projects','self_projects.project_id','=','add_projects.project_id')->join('users','self_projects.user_id','=','users.user_id')->where('self_projects.user_id',$value->user_id)->
            where('self_projects.designation_id','1')->
            where('add_projects.is_deleted','0')->
            where('add_projects.is_archived','0')->select('users.first_name','users.last_name','add_projects.project_name','add_projects.project_id')->distinct('users.user_id','')->get();

            if(count($my_projects)>0)
            {
                $pm_data['pm_name']=$my_projects[0]->first_name." ".$my_projects[0]->last_name;
    
    foreach($my_projects as $project_key=>$project_value)
    {
        
        $pm_data["$project_value->project_name"]["users"]=array();
        
        $users_for_project=DB::table('users')->join('day_times','users.user_id','=','day_times.user_id')->where('day_times.project_name',$project_value->project_id)->where('date',$todays_date)
        ->select('users.first_name','users.last_name')->distinct('self_projects.user_id')->get();
        if(count($users_for_project)>0)
        {
            foreach($users_for_project as $users_for_project_key=>$users_for_project_value)
            {
                $user_name=$users_for_project_value->first_name." ".$users_for_project_value->last_name;
                array_push($pm_data[$project_value->project_name]["users"],$user_name);
            }
        }
        
        
        $project_timesheet=DB::table('day_times')->
                           where('project_name',$project_value->project_id)->
                           where('date',$todays_date)->lists('hrs_locked');
        if(count($project_timesheet)>0)
        {
$pm_data["$project_value->project_name"]["hrs_locked"]=$this->getminutes($project_timesheet);
        }
        else
        {
            $pm_data["$project_value->project_name"]["hrs_locked"]="0:00";
        }

        $project_timesheet_to_date=DB::table('day_times')->
                           where('project_name',$project_value->project_id)->
                          lists('hrs_locked');
                          if(count($project_timesheet_to_date)>0)
        {
$pm_data["$project_value->project_name"]["hrs_locked_to_date"]=$this->getminutes($project_timesheet_to_date);
        }
        else
        {
            $pm_data["$project_value->project_name"]["hrs_locked_to_date"]="0:00";
        }
            $project_estimated_hrs=DB::table('phase_individual_resources')->where('project_id',$project_value->project_id)->where('ph_id','<>','8')->lists('actual_hrs');
$pm_data["$project_value->project_name"]["project_id"]=$project_value->project_id;
         if(count($project_estimated_hrs)>0)
        {
$pm_data["$project_value->project_name"]["project_estimated_hrs"]=$this->getminutes($project_estimated_hrs);
        }
        else
        {
            $pm_data["$project_value->project_name"]["project_estimated_hrs"]="0:00";
        }
    }

}


}
    }
}
