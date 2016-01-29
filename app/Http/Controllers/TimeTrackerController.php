<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Project;
use App\Activity;
use App\TrackProjectTime;
use App\TrackActivityTime;
use Input;
use Redirect;
use DB;
use Response;
use Session;

class TimeTrackerController extends Controller
{
    /**
     * Display a timesheet list.
     *
     * @return Response
     */
    public function index()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1 || $session == 2)
      {
        $user_id = Session::get('user')[0]['user_id'];
        $created_project_timesheet = TrackProjectTime::where('user_id', $user_id)->where('saved_date', date('Y-m-d'))->get();
        $created_activity_timesheet = TrackActivityTime::where('user_id', $user_id)->where('saved_date', date('Y-m-d'))->get();
        $pending_project_timesheets = TrackProjectTime::where('user_id', $user_id)->where('submit_status', 0)->groupBy('saved_date')->get();
        $pending_activity_timesheets = TrackActivityTime::where('user_id', $user_id)->where('submit_status', 0)->groupBy('saved_date')->get();
        return view('time_tracker/index', compact('pending_project_timesheets', 'pending_activity_timesheets', 'created_project_timesheet', 'created_activity_timesheet'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Show the form for creating a new timesheet.
     *
     * @return Response
     */
    public function create($date)
    {
      $session = Session::get('user')[0]['role_id'];
      $user_id = Session::get('user')[0]['user_id'];
      if($session == 1 || $session == 2)
      {
        $created_timesheet = TrackProjectTime::where('user_id', $user_id)->where('saved_date', $date)->get();
        if(isset($created_timesheet[0]))
        {
          return "Timesheet Already created for date: $date. <a href='/time-management'>Click here to go back</a>";
        }
        $projects = Project::lists('project_name','project_id')->toArray();
        $activities = Activity::lists('activity_name','activity_id')->toArray();
        $timesheet_date = $date;
        return view('time_tracker/create', compact('user_id', 'projects', 'activities', 'timesheet_date'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

     /**
     * Show the form for creating a previous date timesheet.
     *
     * @return Response
     */
    public function createPreviousTimesheet()
    {
      $session = Session::get('user')[0]['role_id'];
      $user_id = Session::get('user')[0]['user_id'];
      if($session == 1 || $session == 2)
      {
        $date = $_POST['selectedDate'];
        if($date >= date('Y-m-d'))
        {
          return "Please select previous date.";
        }
        else
        {
          $created_project_timesheet = TrackProjectTime::where('user_id', $user_id)->where('created_at', 'LIKE', "%$date%")->get();
          $created_activity_timesheet = TrackActivityTime::where('user_id', $user_id)->where('created_at', 'LIKE', "%$date%")->get();
          if(count($created_project_timesheet) || count($created_activity_timesheet))
          {
            return "Timesheet for $date is already created.";
          }
          else
          {
            return "Timesheet not created";
          }
        }
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Store a newly created timesheet in database.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, $id, $date)
    {
      $session = Session::get('user')[0]['role_id'];
      $user_id = Session::get('user')[0]['user_id'];
      if(($session == 1 || $session == 2) && $user_id == $id) {
        // $this->validate($request, [
        //   'client-name'         => 'required'
        // ]);

        $project_id = array();
        $project_hours = array();
        $activity_id = array();
        $activity_hours = array();
        if(Input::get('project-id'))
        {
          foreach(Input::get('project-id') as $pid)
          {
            array_push($project_id, $pid);
          }

          foreach(Input::get('project-hours') as $phours)
          {
            array_push($project_hours, $phours);
          }

          foreach($project_id as $key => $value)
          {
            $track_project_time = new TrackProjectTime;
            $track_project_time->user_id = $id;
            $track_project_time->project_id = $value;
            $track_project_time->invested_time = $project_hours[$key];
            $track_project_time->saved_date = $date;
            $track_project_time->save();
          }
        }

        if(Input::get('activity-id'))
        {
          foreach(Input::get('activity-id') as $aid)
          {
            array_push($activity_id, $aid);
          }

          foreach(Input::get('activity-hours') as $ahours)
          {
            array_push($activity_hours, $ahours);
          }

          foreach($activity_id as $key => $value)
          {
            $track_activity_time = new TrackActivityTime;
            $track_activity_time->user_id = $id;
            $track_activity_time->activity_id = $value;
            $track_activity_time->invested_time = $activity_hours[$key];
            $track_activity_time->saved_date = $date;
            $track_activity_time->save();
          }
        }

        return Redirect::to('/time-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Display the specified client.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified Timesheet.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id, $date)
    {
      $session = Session::get('user')[0]['role_id'];
      $user_id = $id;
      $saved_date = $date;
      if($session == 1 || $session == 2) {
        $projects = Project::lists('project_name','project_id')->toArray();
        $activities = Activity::lists('activity_name','activity_id')->toArray();
        $pending_project_timesheet = TrackProjectTime::where('user_id', $user_id)->where('saved_date', $date)->get();
        $pending_activity_timesheet = TrackActivityTime::where('user_id', $user_id)->where('saved_date', $date)->get();
        return view('time_tracker/edit', compact('user_id', 'saved_date', 'projects', 'activities', 'pending_project_timesheet', 'pending_activity_timesheet'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Update the specified Timesheet in database.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $user_id, $date)
    {
      $session = Session::get('user')[0]['role_id'];
      $uid = Session::get('user')[0]['user_id'];
      if(($session == 1 || $session == 2) && $uid == $user_id)
      {
        // $this->validate($request, [
        //   'client-name'         => 'required'
        // ]);

        $existing_project_id = array();
        $existing_project_hours = array();
        $existing_activity_id = array();
        $existing_activity_hours = array();
        $project_id = array();
        $project_hours = array();
        $activity_id = array();
        $activity_hours = array();

        if(Input::get('existing-project-id'))
        {
          foreach(Input::get('existing-project-id') as $pid)
          {
            array_push($existing_project_id, $pid);
          }

          foreach(Input::get('existing-project-hours') as $phours)
          {
            array_push($existing_project_hours, $phours);
          }

          foreach($existing_project_id as $key => $value)
          {
            $track_project_time = TrackProjectTime::where('user_id', $user_id)->where('project_id', $value)->where('saved_date', $date)->get();
            $track_project_time[0]->invested_time = $existing_project_hours[$key];
            $track_project_time[0]->save();
          }
        }

        if(Input::get('project-id'))
        {
          foreach(Input::get('project-id') as $pid)
          {
            array_push($project_id, $pid);
          }

          foreach(Input::get('project-hours') as $phours)
          {
            array_push($project_hours, $phours);
          }

          foreach($project_id as $key => $value)
          {
            $track_project_time = new TrackProjectTime;
            $track_project_time->user_id = $user_id;
            $track_project_time->project_id = $value;
            $track_project_time->invested_time = $project_hours[$key];
            $track_project_time->saved_date = $date;
            $track_project_time->save();
          }
        }

        if(Input::get('existing-activity-id'))
        {
          foreach(Input::get('existing-activity-id') as $aid)
          {
            array_push($existing_activity_id, $aid);
          }

          foreach(Input::get('existing-activity-hours') as $ahours)
          {
            array_push($existing_activity_hours, $ahours);
          }

          foreach($existing_activity_id as $key => $value)
          {
            $track_activity_time = TrackActivityTime::where('user_id', $user_id)->where('activity_id', $value)->where('saved_date', $date)->get();
            $track_activity_time[0]->invested_time = $existing_activity_hours[$key];
            $track_activity_time[0]->save();
          }
        }

        if(Input::get('activity-id'))
        {
          foreach(Input::get('activity-id') as $aid)
          {
            array_push($activity_id, $aid);
          }

          foreach(Input::get('activity-hours') as $ahours)
          {
            array_push($activity_hours, $ahours);
          }

          foreach($activity_id as $key => $value)
          {
            $track_activity_time = new TrackActivityTime;
            $track_activity_time->user_id = $user_id;
            $track_activity_time->activity_id = $value;
            $track_activity_time->invested_time = $activity_hours[$key];
            $track_activity_time->saved_date = $date;
            $track_activity_time->save();
          }
        }

        return Redirect::to('/time-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Submit the specified Timesheet in database.
     *
     * @param  int  $id, $date
     * @return Response
     */
    public function submit($id, $date)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1 || $session == 2) {
        $project_timesheet = TrackProjectTime::where('user_id', $id)->where('saved_date', $date)->get();

        foreach($project_timesheet  as $timesheet)
        {
          $timesheet->submitted_date = date('Y-m-d');
          $timesheet->submit_status = 1;
          $timesheet->save();
        }

        $activity_timesheet = TrackActivityTime::where('user_id', $id)->where('saved_date', $date)->get();

        foreach($activity_timesheet  as $timesheet)
        {
          $timesheet->submitted_date = date('Y-m-d');
          $timesheet->submit_status = 1;
          $timesheet->save();
        }

        return Redirect::to('/time-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Remove the specified timesheet project entry from database.
     *
     * @param  int  $user_id, $project_id, $saved_date
     * @return Response
     */
    public function removeProject($user_id, $project_id, $saved_date)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1 || $session == 2) {
        $project_timesheet = TrackProjectTime::where('user_id', $user_id)->where('project_id', $project_id)->where('saved_date', $saved_date)->delete();

        return Redirect::to("/edit-timesheet/$user_id/$saved_date");
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Remove the specified timesheet activity entry from database.
     *
     * @param  int  $user_id, $activity_id, $saved_date
     * @return Response
     */
    public function removeActivity($user_id, $activity_id, $saved_date)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1 || $session == 2) {
        $activity_timesheet = TrackActivityTime::where('user_id', $user_id)->where('activity_id', $activity_id)->where('saved_date', $saved_date)->delete();

        return Redirect::to("/edit-timesheet/$user_id/$saved_date");
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Remove the specified Timsheet from database.
     *
     * @param  int  $id, $date
     * @return Response
     */
    public function destroy($id, $date)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1 || $session == 2) {
        $project_timesheet = TrackProjectTime::where('user_id', $id)->where('saved_date', $date)->delete();

        $activity_timesheet = TrackActivityTime::where('user_id', $id)->where('saved_date', $date)->delete();

        return Redirect::to('/time-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }
}
