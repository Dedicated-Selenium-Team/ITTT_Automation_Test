<?php

namespace App\Http\Controllers;

use App\User;
use App\AddProject;
use App\DayTime;
use App\Http\Controllers\Controller;

use App\ProjectDesignation;
use App\SelfProject;
use DateInterval;

use DatePeriod;
use Datetime;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Request as RequestHttp;
use Input;
use Redirect;
use Response;
use Session;

class TimeTrackerController extends Controller {
  /**
   * Display a timesheet list.
   *
   * @param $date
   * @return View
   */
  public function index($date) {
    $session = Session::get('user')[0]['role_id'];
    if ($session == 1 || $session == 2) {
      preg_match_all('![0-9,-]+!', $date, $current);
      $date          = $current[0][0];
      $user_id       = Session::get('user')[0]['user_id'];
      $project_info  = SelfProject::distinct()->select('project_id')->where('user_id', $user_id)->get();
      if(count($project_info)>0)
        $is_project_assigned=1;
      else
        $is_project_assigned=0;
      $projects      = [];
      $projectId     = [];
      $daily_project = [];
      $today_project = DB::table('add_projects')
      ->join('day_times', 'day_times.project_name', '=', 'add_projects.project_id')
      ->where('day_times.user_id', $user_id)->where('day_times.date', $date)
      ->select('day_times.*', 'add_projects.project_name')
      ->get();
      if ($today_project) {
        foreach ($today_project as $key => $value) {
          $value1      = (array) $value;
          $designation = DB::table('project_designations')->select('d_name')->where('d_id', $value1['d_id'])->get();
          foreach ($designation as $key1 => $designation_value)
            $designation_array = (array) $designation_value;
          $designation_name  = ($designation_array['d_name']);
          $value1['designation_name'] = $designation_name;
          $value                      = (object) $value1;
          $value->hrs_locked=str_replace('.',':', number_format($value->hrs_locked,2));
          
          array_push($daily_project, $value);
        }
      }
      $project_id = [];
      $test       = [];
      //this for loop is used on pop-up window of day view//
      for ($i = 0; $i < count($project_info); $i++) {
        $project_id[$i] = $project_info[$i]->project_id;
        $current        = $project_info[$i]->project_id;
        //->where('is_deleted','0')->where('is_archived','0')
        $project_name   = AddProject::select('project_name')->where('project_id', $current)->where('is_deleted','0')->where('is_archived','0')->get()->first();
        if ($project_name) {
          $temp                 = array();
          $temp['project_id']   = $project_id[$i];
          $temp['project_name'] = $project_name->project_name;
          array_push($test, $project_name);
          array_push($projects, $temp);
        }

      }
      return view('time_tracker/day', compact('projects', 'daily_project', 'date','is_project_assigned'));

    } else {
      return Redirect::to('/');
    }
  }

  /**
   * Store a newly created timesheet in database.
   *
   * @param  RequestHttp  $request
   * @return json object
   */
  public function storeTime(RequestHttp $request) {
    $time    = new DayTime;
    $user_id = Session::get('user')[0]['user_id'];

    $success=1;
    // store the timesheet values into databse
    $time->user_id      = $user_id;
    $time->project_name = Input::get('project_id');
    $time->date         = Input::get('date');
    $time->comments     = Input::get('comments');
    $time->hrs_locked   = Input::get('hidden_Hrs');
    $time->d_id         = Input::get('project_desig');
    $time->save();

    $date = Input::get('date');

    $project_name = DB::table('add_projects')
    ->join('day_times', 'day_times.project_name', '=', 'add_projects.project_id')
    ->join('project_designations', 'day_times.d_id', '=', 'project_designations.d_id')
    ->where('day_times.user_id', $user_id)  ->where('day_times.date', $date)
    ->where('day_times.d_id', $time->d_id)
    ->where('day_times.project_name', $time->project_name)
    ->select('day_times.*', 'add_projects.project_name', 'project_designations.d_name') ->get();

    //$project_name=$time;
    return response()->json([
      'project_name' => $project_name,
      'success'=>$success

      ]);

  }

  /**
   * Show the pop-up form for editing the specified Timesheet.
   *
   * @param  Request $request
   * @return json object
   */
  public function editProject(Request $request) {
    $session = Session::get('user')[0]['role_id'];
    if ($session == 1 || $session == 2) {
      // fetch the data of requested id and display it onto pop-up view
      if ($request->ajax()) {
        $time             = DayTime::find($request->header('id'));
        $designation_name = ProjectDesignation::select('d_name')->where('d_id', $time->d_id)->get()->first()->d_name;
        $time->d_name     = $designation_name;
        return Response($time);
      }
    } else {
      return Redirect::to('/');
    }
  }

  /**
   * Update the specified Timesheet in database.
   *
   * @param  Request  $request
   * @param  int  $id
   * @return json object
   */
  public function updateTime(Request $request, $id, $project_id) {
    if ($request->ajax()) {
      $day_time = new DayTime();

      // fetch the data  of the requested id from database and update the changes
      $day_time->where('id', $id)->update([
        'project_name' => $project_id,
        'comments'     => Input::get('comments'),
        'hrs_locked'   => Input::get('hidden_Hrs')
        ]);
      $time = DayTime::find($id);
      // $project_id=$time->project_name;
      //  echo $request->header('project_id');
      $project_name       = DB::table('add_projects')->select('project_name')->where('project_id', $project_id)->get();
      $time->project_name = $project_name[0]->project_name;
      $designation        = DB::table('project_designations')->select('d_name')->where('d_id', $time->d_id)->get();
      foreach ($designation as $key1 => $designation_value)
        $designation_array      = (array) $designation_value;
      $time->designation_name = ($designation_array['d_name']);

      return response()->json($time);
    }
    //
  }

  /**
   * Remove the specified Timsheet from database.
   *
   * @param  Request  $request
   * @param  int  $id
   * @return json object
   */
  public function deleteTime(Request $request, $id) {
    if ($request->ajax()) {
      $time = DayTime::find($id);
      if ($time) {

        $time->delete();
        return response()->json([
          'id'      => $request->id,
          'success' => 1
          ]);
      } else {
        return response()->json([
          'success' => 0
          ]);
      }

    }
  }

  /**
   * Display the week view of Timsheet.
   *
   * @param  int  $date
   * @return view
   */
  public function week($date) {
    $updated_date = strtotime($date);
    if (date('w', $updated_date) == 1)
    {
      $updated_date=$date;
    }
    else
    {
      $updated_date_timestamp =  strtotime('last monday',
        $updated_date);
      $updated_date=date('Y-m-d',$updated_date_timestamp);
    }
    $session      = Session::get('user')[0]['role_id'];
    if ($session == 1 || $session == 2) {
      $user_id      = Session::get('user')[0]['user_id'];
      $project_info  = SelfProject::distinct()->select('project_id')->where('user_id', $user_id)->get();
      if(count($project_info)>0)
        $is_project_assigned=1;
      else
        $is_project_assigned=0;
      $start        = new DateTime($updated_date);
      $end          = new DateTime($updated_date);
      $end->add(new DateInterval('P7D'));
      $interval = DateInterval::createFromDateString('1 day');
      $period   = new DatePeriod($start, $interval, $end);

      $projects          = [];
      $project_date      = [];
      $user_proj_details = [];
      $user_proj_name    = [];

      for ($i = 0; $i < count($project_info); $i++) {
        $current = $project_info[$i]->project_id;
        //echo $current;
        $project_name = AddProject::select('project_name')->where('project_id', $current)->get()->first();
        if($project_name)
        {
          array_push($projects, $project_name);
          
          $user_proj_name[$i] = $project_name;
        // array_push($user_proj_name, $project_name);
          $project_id = AddProject::select('project_id')->where('project_name', $project_name->project_name)->get()->first()->project_id;
          foreach ($period as $key => $value) {
            $final_date = $value->format("Y-m-d");
            $dates      = DayTime::select('date', 'd_id', 'project_name', 'hrs_locked')->where('user_id', $user_id)->where('project_name', $project_id)->where('date', $final_date)->get()->first();
            
            $project_detail = DB::table('add_projects')
            ->join('day_times', 'day_times.project_name', '=', 'add_projects.project_id')
            ->join('project_designations', 'project_designations.d_id', '=', 'day_times.d_id')
            ->where('day_times.user_id', $user_id)  ->where('day_times.date', $final_date)
            ->where('day_times.project_name', $project_id)
            ->select('day_times.date', 'day_times.project_name', 'day_times.hrs_locked', 'day_times.d_id', 'add_projects.project_name') ->get();
            /*foreach($project_detail as $project_detail_key=>$project_detail_value)
            {
              $project_detail_value->hrs_locked=str_replace('.',':', $project_detail_value->hrs_locked);
            }*/

            array_push($project_date, $dates);
            
            array_push($user_proj_details, $project_detail);
            /*echo json_encode($user_proj_details);
            exit();*/
          }
        }
        
      }

      $user_weekly_details = array_chunk($user_proj_details, 7);

      
      foreach ($user_weekly_details as $user_weekly_details_key=>$user_weekly_details_value) {
        $user_proj_name[$user_weekly_details_key]->project_details = $user_weekly_details[$user_weekly_details_key];


      }
      
      
      return view('time_tracker/week', compact('period', 'projects', 'project_date', 'user_proj_name', 'date','end','is_project_assigned'));
    } else {
      return Redirect::to('/');
    }
  }

  public function getDesignation($project_id) {
    $user_id     = Session::get('user')[0]['user_id'];
    $designation = DB::table('self_projects')->select('designation_id')->where('project_id', $project_id)->where('user_id', $user_id)->get();

    return response()->json($designation);
  }

  /**
   * Display user timeseet
   */
  public function getUserTimesheet($date,$id,$project_id="") {
    if($project_id==""){
      $unique_project_id = 0;
    } else {
      $unique_project_id = $project_id;
    }
    $session = Session::get('user')[0]['role_id'];
    $session_user_id       = Session::get('user')[0]['user_id'];

    if ($session_user_id == $id) {
      return Redirect::to("time-management/{$date}");
    } else 
    if ($session == 1) {
      preg_match_all('![0-9,-]+!', $date, $current);
      $date          = $current[0][0];
      $user_id       = $id;
      $user_data = User::select('first_name','last_name')->where('user_id', $user_id)->get();
      if (count($user_data) > 0) {
        $userName = $user_data[0]->first_name;
        $userSirName = $user_data[0]->last_name;
        $userFullName = $userName." ".$userSirName ;
      } 
      $project_info  = SelfProject::distinct()->select('project_id')->where('user_id', $user_id)->get();
      $flag = 1;
      if(count($project_info)>0)
        $is_project_assigned=1;
      else
        $is_project_assigned=0;
      $projects      = [];
      $projectId     = [];
      $daily_project = [];
      $today_project = DB::table('add_projects')
      ->join('day_times', 'day_times.project_name', '=', 'add_projects.project_id')
      -> where('day_times.date', $date)
      ->where('day_times.user_id',$user_id)
      ->select('day_times.*', 'add_projects.project_name')
      ->get();

      if ($today_project) {
        foreach ($today_project as $key => $value) {
          $value1      = (array) $value;
          $designation = DB::table('project_designations')->select('d_name')->where('d_id', $value1['d_id'])->get();
          foreach ($designation as $key1 => $designation_value)
            $designation_array = (array) $designation_value;
          $designation_name  = ($designation_array['d_name']);
          $value1['designation_name'] = $designation_name;
          $value                      = (object) $value1;
          $value->hrs_locked=str_replace('.',':', number_format($value->hrs_locked,2));
          
          array_push($daily_project, $value);
        }
      }
      $project_id = [];
      //this for loop is used on pop-up window of day view//
      for ($i = 0; $i < count($project_info); $i++) {
        $project_id[$i] = $project_info[$i]->project_id;
        $current        = $project_info[$i]->project_id;
        $project_name   = AddProject::select('project_name')->where('project_id', $current)->get()->first();
        if ($project_name) {
          $temp                 = array();
          $temp['project_id']   = $project_id[$i];
          $temp['project_name'] = $project_name->project_name;
          
          array_push($projects, $temp);
        }

      }
      
      return view('time_tracker/userDayTimesheet', compact('projects', 'daily_project', 'date','is_project_assigned','id','userFullName','unique_project_id'));

    } else {
      return Redirect::to('/');
    }
  }

  public function getUserWeekTimesheet($date,$id,$project_id="") {
    if($project_id==""){
      $unique_project_id = 0;
    } else {
      $unique_project_id = $project_id;
    }
    $updated_date = strtotime($date);
    if (date('w', $updated_date) == 1)
    {
      $updated_date=$date;
    }
    else
    {
      $updated_date_timestamp =  strtotime('last monday',
        $updated_date);
      $updated_date=date('Y-m-d',$updated_date_timestamp);
    }
    $session      = Session::get('user')[0]['role_id'];
    if ($session == 1 ) {
      $user_id      = $id;
      $user_data = User::select('first_name','last_name')->where('user_id', $user_id)->get();
      if (count($user_data) > 0) {
        $userName = $user_data[0]->first_name;
        $userSirName = $user_data[0]->last_name;
        $userFullName = $userName." ".$userSirName ;
      } 
      $project_info  = SelfProject::distinct()->select('project_id')->where('user_id', $user_id)->get();
      if(count($project_info)>0)
        $is_project_assigned=1;
      else
        $is_project_assigned=0;
      $start        = new DateTime($updated_date);
      $end          = new DateTime($updated_date);
      $end->add(new DateInterval('P7D'));
      $interval = DateInterval::createFromDateString('1 day');
      $period   = new DatePeriod($start, $interval, $end);

      $projects          = [];
      $project_date      = [];
      $user_proj_details = [];
      $user_proj_name    = [];

      //exit();
      for ($i = 0; $i < count($project_info); $i++) {
        $current = $project_info[$i]->project_id;
        //echo $current;
        $project_name = AddProject::select('project_name')->where('project_id', $current)->get()->first();
        if($project_name)
        {
          array_push($projects, $project_name);
          
          $user_proj_name[$i] = $project_name;
        // array_push($user_proj_name, $project_name);
          $project_id = AddProject::select('project_id')->where('project_name', $project_name->project_name)->get()->first()->project_id;
          foreach ($period as $key => $value) {
            $final_date = $value->format("Y-m-d");
            $dates      = DayTime::select('date', 'd_id', 'project_name', 'hrs_locked')->where('user_id', $user_id)->where('project_name', $project_id)->where('date', $final_date)->get()->first();
            
            $project_detail = DB::table('add_projects')
            ->join('day_times', 'day_times.project_name', '=', 'add_projects.project_id')
            ->join('project_designations', 'project_designations.d_id', '=', 'day_times.d_id')
            ->where('day_times.user_id', $user_id)  ->where('day_times.date', $final_date)
            ->where('day_times.project_name', $project_id)
            ->select('day_times.date', 'day_times.project_name', 'day_times.hrs_locked', 'day_times.d_id', 'add_projects.project_name') ->get();
            

            array_push($project_date, $dates);
            
            array_push($user_proj_details, $project_detail);
            
          }
        }
        
      }
      

      $user_weekly_details = array_chunk($user_proj_details, 7);
      /*echo json_encode($user_proj_name);
      exit();*/
      foreach ($user_weekly_details as $user_weekly_details_key=>$user_weekly_details_value) {
        $user_proj_name[$user_weekly_details_key]->project_details = $user_weekly_details[$user_weekly_details_key];

      }

      
      return view('time_tracker/userWeekTimesheet', compact('period', 'projects', 'project_date', 'user_proj_name', 'date','end','is_project_assigned','id','userFullName','unique_project_id'));
    } else {
      return Redirect::to('/');
    }
  }
}
