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
use App;
use PDF; 
use PHPExcel;
use PHPExcel_IOFactory;

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
          $value->comments=json_encode($value->comments);
          $value->comments=str_replace('\\r\\n','<br>',$value->comments);
          $value->comments=str_replace('"','',$value->comments);

          
          
          
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
      $client_name_list=DB::table('add_projects')->distinct('client_name')->select('client_name')->lists('client_name');
      
      return view('time_tracker/day', compact('projects', 'daily_project', 'date','is_project_assigned','client_name_list'));

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
    
    $date = Input::get('date');
    $current_date=strtotime(date('Y-m-d'));
    $check_date=strtotime($date);
    if($current_date>$check_date)
    {
      $success=2;
      return response()->json([
        'success'=>$success
        ]);
    }
    else
    {
      $time->user_id      = $user_id;
      $time->project_name = Input::get('project_id');
      $time->date         = date('Y-m-d');
    //Input::get('date');
      $time->comments     = Input::get('comments');
      $time->hrs_locked   = Input::get('hidden_Hrs');
      $time->d_id         = Input::get('project_desig');
      $time->save();
      $project_name = DB::table('add_projects')
      ->join('day_times', 'day_times.project_name', '=', 'add_projects.project_id')
      ->join('project_designations', 'day_times.d_id', '=', 'project_designations.d_id')
      ->where('day_times.user_id', $user_id)  ->where('day_times.date', $date)
      ->where('day_times.d_id', $time->d_id)
      ->where('day_times.project_name', $time->project_name)
      ->select('day_times.*', 'add_projects.project_name', 'project_designations.d_name') ->get();
      return response()->json([
        'project_name' => $project_name,
        'success'=>$success

        ]);

    }
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
          $value->comments=json_encode($value->comments);
          $value->comments=str_replace('\\r\\n','<br>',$value->comments);
          $value->comments=str_replace('"','',$value->comments);

          
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
  public function export(Request $request,$date,$strDownloadFor = "day",$strDownloadType = 'excel',$userID = '')
  { 
    //set default values 
    $arrExportParameter = array();
    //echo $date;exit();
    $arrExportParameter['date'] = !empty($date) ? date("Y-m-d",strtotime($date)) : date("Y-m-d");
    $arrExportParameter['strDownloadType'] = !empty($strDownloadType) ? $strDownloadType : 'excel';
    $arrExportParameter['userID'] = !empty($userID) ? $userID : Session::get('user')[0]['user_id'] ;

    //calculate start day and end day 
    if($strDownloadFor == 'week'){
      $dateStartDay = strtotime($date);
      if (date('w', $dateStartDay) == 1)
      {
        $dateStartDay=$date;
      }
      else
      {
        $dateStartDay_timestamp =  strtotime('last monday',
          $dateStartDay);
        $dateStartDay=date('Y-m-d',$dateStartDay_timestamp);
      }
      $start_date        = new \DateTime($dateStartDay);
      $end_date          = new \DateTime($dateStartDay);
      $arrExportParameter['dateStartDay'] = $dateStartDay. " 00:00:00" ;
      
      $arrExportParameter['dateLastDay'] = date("Y-m-d",strtotime($dateStartDay."+7 days")) . " 00:00:00";
    }else{
      $arrExportParameter['dateStartDay'] = $date." 00:00:00";
      $arrExportParameter['dateLastDay'] = $date." 23:59:59";
    }
    $request->session()->put('arrExportParameter', $arrExportParameter); 
    if($arrExportParameter['strDownloadType'] == 'excel'){
      \Excel::create('Report2016', function($excel) {
              // Set the title
        $excel->setTitle('My awesome report 2016');
              // Chain the setters
        $excel->setCreator('Me')->setCompany('Our Code World');
        $excel->setDescription('A demonstration to change the file properties');

        $excel->sheet('Sheet 1', function ($sheet)  {
          DB::enableQueryLog();
          $arrExportParameter = Session::get('arrExportParameter');
          $today_project = DB::table('add_projects')
          ->join('day_times', 'day_times.project_name', '=', 'add_projects.project_id')
          ->join('project_designations','day_times.d_id','=','project_designations.d_id')
          ->where('day_times.user_id', $arrExportParameter['userID'])
          ->whereBetween('day_times.date',array($arrExportParameter['dateStartDay'], $arrExportParameter['dateLastDay']))
          ->select('day_times.*', 'add_projects.project_name','project_designations.d_name','add_projects.client_name')
          ->get();

          if(count($today_project)==0)
            return "No data to Show";
              //echo "<pre>";print_r($today_project);exit();
          $export_data=array();
          $tmp=array();
          array_push($tmp,'Date');
          array_push($tmp,'Client_name');
          array_push($tmp,'Project Name');
          array_push($tmp,'Designation');
          array_push($tmp,'Description');
          array_push($tmp,'Hrs Locked');
          array_push($export_data,$tmp);
          foreach($today_project as $key=>$value)
          {
            $tmp=array();
            array_push($tmp,$value->date);
            array_push($tmp,$value->client_name);
            array_push($tmp,$value->project_name);
            array_push($tmp,$value->d_name);
            array_push($tmp,$value->comments);
            array_push($tmp,$value->hrs_locked);
            array_push($export_data,$tmp);
          }
                //$sheet->setAutoSize(true);
          $sheet->getDefaultRowDimension()->setRowHeight(20);
          $sheet->fromArray($export_data, null, 'A1', true,false);
        });

      })->download('xls');
      $response = array(
        'success' => true,
        'url' => 'http://localhost:8000/time-management/2017-02-08/'
        );

      header('Content-type: application/json');
    }elseif($arrExportParameter['strDownloadType'] == 'pdf'){

      $today_project = DB::table('add_projects')
      ->join('day_times', 'day_times.project_name', '=', 'add_projects.project_id')
      ->join('project_designations','day_times.d_id','=','project_designations.d_id')
      ->join('users','users.user_id','=','day_times.user_id')
      ->where('day_times.user_id', $arrExportParameter['userID'])
      ->whereBetween('day_times.date',array($arrExportParameter['dateStartDay'], $arrExportParameter['dateLastDay']))
      ->select('day_times.*', 'add_projects.project_name','project_designations.d_name','add_projects.client_name','users.first_name','users.last_name')
      ->get();
      $user_name_timesheet=DB::table('users')->where('user_id',$arrExportParameter['userID'])->get();

      $name=$user_name_timesheet[0]->first_name." ".$user_name_timesheet[0]->last_name."'s Timesheet";
              //echo "<pre>";print_r($today_project);exit();
      $export_data=array();
      $tmp=array();
      array_push($tmp,'Date');
      array_push($tmp,'Client_name');
      array_push($tmp,'Project Name');
      array_push($tmp,'Designation');
      array_push($tmp,'Description');
      array_push($tmp,'Hrs Locked');
      array_push($export_data,$tmp);
      foreach($today_project as $key=>$value)
      {
        $tmp=array();
        array_push($tmp,$value->date);
        array_push($tmp,$value->client_name);
        array_push($tmp,$value->project_name);
        array_push($tmp,$value->d_name);
        array_push($tmp,$value->comments);
        array_push($tmp,$value->hrs_locked);
        array_push($export_data,$tmp);
      }
      $name=ucwords($name);

      
      $pdf = PDF::loadView('pdf_export.pdf', compact('export_data','name'));
      
      return $pdf->download('timesheet.pdf');         
    }
    return $response;
  }

}
