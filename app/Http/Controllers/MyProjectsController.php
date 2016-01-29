<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\UserDetails;
use App\Project;
use App\ProjectResources;
use App\TrackProjectTime;
use Input;
use Redirect;
use DB;
use Response;
use Session;

class MyProjectsController extends Controller
{
    /**
     * Display all project associated with a particular user.
     *
     * @return Response
     */
    public function index($user_id)
    {
      $session = Session::get('user')[0]['role_id'];
      $session_user_id = Session::get('user')[0]['user_id'];
      if(($session == 1 || $session == 2) && $session_user_id == $user_id)
      {
        $project_info = Project::with('ProjectResources')->get();
        $user_info = User::with('UserDetails')->where('user_id', $user_id)->get();
        $users  = User::select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, concat (user_details.user_id," ",user_details.designation_id ) as user_id'))->join('user_details', 'user_details.user_id', '=', 'users.user_id')->whereNotIn('users.user_id', [$user_id])->lists('full_name', 'user_id');
        $project_timesheet_info = TrackProjectTime::where('submit_status', 1)->where('user_id', $user_id)->get();

        $user_projects_hours = array();
        foreach ($project_timesheet_info as $timesheet)
        {
          if(array_key_exists($timesheet->project_id, $user_projects_hours))
          {
            array_push($user_projects_hours[$timesheet->project_id], $timesheet->invested_time);
          }
          else
          {
            $user_projects_hours[$timesheet->project_id] = array("0" => $timesheet->invested_time);
          }

        }
        return view('my_projects/index', compact('project_info', 'user_info', 'user_projects_hours', 'users'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Display all project associated with a particular user.
     *
     * @return Response
     */
    public function allocateHours($project_id, $user_id, $project_hours)
    {
      $session = Session::get('user')[0]['role_id'];
      $session_user_id = Session::get('user')[0]['user_id'];
      if(($session == 1 || $session == 2) && $session_user_id == $user_id)
      {
        $resource_id = array();
        $designation_id = array();
        $resource_hours = array();

        if(Input::get('resource-id'))
        {
          $hours_count = 0;
          foreach(Input::get('resource-id') as $id)
          {
            array_push($resource_id, $id);
          }
          foreach(Input::get('designation-id') as $id)
          {
            array_push($designation_id, $id);
          }
          foreach(Input::get('resource-hours') as $hours)
          {
            array_push($resource_hours, $hours);
            $hours_count += $hours;
          }

          if($project_hours >= $hours_count)
          {
            foreach($resource_id as $key => $value)
            {
              $existing_project_resources = ProjectResources::where('project_id', $project_id)->where('user_id', $value)->get();
              if(count($existing_project_resources))
              {
                $existing_project_resources[0]->project_id = $project_id;
                $existing_project_resources[0]->user_id = $value;
                $existing_project_resources[0]->designation_id = $designation_id[$key];
                $existing_project_resources[0]->hours = ($existing_project_resources[0]['hours'] + $resource_hours[$key]);
                $existing_project_resources[0]->save();
              }
              else
              {
                $project_resources = new ProjectResources;
                $project_resources->project_id = $project_id;
                $project_resources->user_id = $value;
                $project_resources->designation_id = $designation_id[$key];
                $project_resources->hours = $resource_hours[$key];
                $project_resources->save();
              }
              $project_resources = ProjectResources::where('project_id', $project_id)->where('user_id', $user_id)->get();
              $project_resources[0]->project_id = $project_id;
              $project_resources[0]->user_id = $user_id;
              $project_resources[0]->designation_id = $project_resources[0]['designation_id'];
              $project_resources[0]->hours = ($project_resources[0]['hours'] - $hours_count);
              $project_resources[0]->save();
            }
          }
          else
          {
            echo "Insufficient hours";
          }
        }

        return Redirect::to("/my-projects/$user_id");
      }
    }
}
