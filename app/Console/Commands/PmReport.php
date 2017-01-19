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
where('add_projects.status_id','<>','4')->select('self_projects.user_id','self_projects.project_id')->distinct('self_projects.user_id')->get();
foreach($all_pm_user_id as $key=>$value)
{
    $pm_data=array();
    $my_projects=DB::table('self_projects')->join('users','self_projects.user_id','=','users.user_id')->where('self_projects.user_id',$value->user_id)->get();
    echo json_encode($my_projects);
    exit();
}





    }
}
