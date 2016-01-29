<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Project;
use App\TrackProjectTime;
use Input;
use Redirect;
use DB;
use Response;
use Session;

class ReportController extends Controller
{
    /**
     * Display all project and user reports.
     *
     * @return Response
     */
    public function index()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1 || $session == 2)
      {
        $project_info = Project::with('ProjectResources')->get();
        $project_timesheet_info = TrackProjectTime::where('submit_status', 1)->orderBy('project_id', 'asc')->get();
        $user_info = User::with('UserDetails')->get();

        $users_projects_hours = array();
        foreach ($project_timesheet_info as $timesheet)
        {
          if(array_key_exists($timesheet->user_id, $users_projects_hours))
          {
            if(array_key_exists($timesheet->project_id, $users_projects_hours[$timesheet->user_id]))
            {
              $users_projects_hours[$timesheet->user_id][$timesheet->project_id]["hours-$hours_occurence"] = $timesheet->invested_time;
              $hours_occurence = $hours_occurence + 1;
            }
            else
            {
              $hours_occurence = 0;
              $users_projects_hours[$timesheet->user_id][$timesheet->project_id] = array("hours-$hours_occurence" => $timesheet->invested_time);
              $hours_occurence = $hours_occurence + 1;
            }
          }
          else
          {
            $hours_occurence = 0;
            $users_projects_hours[$timesheet->user_id] = array($timesheet->project_id => array("hours-$hours_occurence" => $timesheet->invested_time));
              $hours_occurence = $hours_occurence + 1;
          }

        }
        return view('report/index', compact('project_info', 'project_timesheet_info', 'user_info', 'users_projects_hours'));
      }
      else
      {
        return 'Access restricted!';
      }
    }
}
