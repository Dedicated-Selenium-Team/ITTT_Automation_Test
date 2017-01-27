<?php

namespace App\Http\Controllers;
use PHPExcel; 
use PHPExcel_IOFactory;
use App\AddProject;

use App\Http\Controllers\Controller;
use App\PhaseIndividualResource;
use App\Phases;
use App\PhaseTime;
use App\ProjectDesignation;
use App\ProjectDetail;
use App\TotalEstimateHrs;


use App\PlanPhaseResource;
use App\PlanPhaseTime;
use App\PlanProjectDetail;
use App\TotalPlanHrs;


use Illuminate\Http\Request;
use Input;
use DB;
use Redirect;
use Session;

class EstimattionController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index($id) {
		$session = Session::get('user')[0]['role_id'];
		date_default_timezone_set("Asia/Kolkata");
		if ($session == 1 || $session == 2) {
			$unique_id = $id;

			$set_estimate = ProjectDetail::where('project_id', $id)->get();
			$proj_detail  = AddProject::select('project_name', 'client_name')->where('project_id', '=', $id)->first();
			$pname        = $proj_detail->project_name;
			$client_name  = $proj_detail->client_name;
			$phase        = array('' => '--Please Select--')+Phases::lists('ph_name', 'ph_id')->toArray();// No use
			if (isset($set_estimate[0])) {
				$time_per_phase                = DB::table('phase_times')
				->join('phases','phases.ph_id','=','phase_times.ph_id')
				->join('phase_mapping','phases.ph_id','=','phase_mapping.phase_id')->select('phases.ph_name','phase_times.ph_id', 'phase_times.spent_days','phase_mapping.display_name')->where('project_id', $id)->get();
				$data=array();
				$data["phase"]=array();
				
				foreach($time_per_phase as $key=>$value)
				{

					$data["phase"][$value->ph_name]=array();
					$tmp=array();
					$data["phase"][$value->ph_name]["phase_id"]=$value->ph_id;
					$data["phase"][$value->ph_name]["spent_days"]=$value->spent_days;
					$data["phase"][$value->ph_name]["display_name"]=$value->display_name;
					$data["phase"][$value->ph_name]["designations"]=array();
					$phase_designation_data=DB::table('phase_individual_resources')
					->join('project_designations','phase_individual_resources.d_id','=','project_designations.d_id')->
					select('project_designations.d_name','phase_individual_resources.ph_id','phase_individual_resources.id', 'phase_individual_resources.d_id', 'phase_individual_resources.spent_hrs')->where('phase_individual_resources.project_id', $id)->
					where('phase_individual_resources.ph_id',$value->ph_id)->get();
						//echo json_encode($phase_designation_data);
					foreach($phase_designation_data as $designation_key=>$designation_value)
					{
						$tmp=array();
						$tmp[$designation_value->d_name]=array();
						$tmp[$designation_value->d_name]["row_id"]=$designation_value->id;
						$tmp[$designation_value->d_name]["d_id"]=$designation_value->d_id;
						$tmp[$designation_value->d_name]["per_day_hours"]=$designation_value->spent_hrs;
							//echo $designation_value->d_name;

						array_push($data["phase"][$value->ph_name]["designations"],$tmp);
					}

					
				}
				
					//echo json_encode($data);
				
				$start_date_timestamp          = strtotime($set_estimate[0]['start_date']);
				$set_estimate[0]['start_date'] = date('d/m/Y', $start_date_timestamp);

				$p_I_live_timestamp          = strtotime($set_estimate[0]['p_I_live']);
				$set_estimate[0]['p_I_live'] = date('d/m/Y', $p_I_live_timestamp);

				$p_II_live_timestamp          = strtotime($set_estimate[0]['p_II_live']);
				$set_estimate[0]['p_II_live'] = date('d/m/Y', $p_II_live_timestamp);

				$warranty_end_date_timestamp        = strtotime($set_estimate[0]['warrenty_period']);
				$set_estimate[0]['warrenty_period'] = date('d/m/Y', $warranty_end_date_timestamp);
				
				return view('project/editEstimate', compact('data','set_estimate', 'unique_id', 'pname', 'phase', 'time_per_phase', 'client_name'));
			} else {
				return view('project/estimate', compact('unique_id', 'pname', 'phase', 'client_name'));
			}
		} else {
			return Redirect::to('/');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */

	public function store(Request $request) {
		$data = Input::get();

		$start_date_timestamp               = strtotime(str_replace("/", "-", Input::get('project-start-date')));
		$start_date                         = date('Y-m-d', $start_date_timestamp);
		$phase1_end_date_timestamp          = strtotime(str_replace("/", "-", Input::get('phase-I-end-date')));
		$phase1_end_date                    = date('Y-m-d', $phase1_end_date_timestamp);
		$phase2_end_date_timestamp          = strtotime(str_replace("/", "-", Input::get('phase-II-end-date')));
		$phase2_end_date                    = date('Y-m-d', $phase2_end_date_timestamp);
		$Warrenty_period_end_date_timestamp = strtotime(str_replace("/", "-", Input::get('Warrenty-period-end')));
		$Warrenty_period_end_date           = date('Y-m-d', $Warrenty_period_end_date_timestamp);
		// Update Entry //
		$editvar  = ProjectDetail::where('project_id', $request->id)->get();
		$editvar1 = PhaseTime::where('project_id', $request->id)->get();
		$editvar2 = PhaseIndividualResource::where('project_id', $request->id)->get();
		$phase      = new Phases;
		$phase_time = new PhaseTime;
		$phase_individual_resource=new PhaseIndividualResource;
		$total_estimated_hrs=new TotalEstimateHrs;
		if (count($editvar) && count($editvar1) && count($editvar2)) {

			$project_detail = new ProjectDetail;
			$phase          = new Phases;
			$project_detail->where('project_id', $request->id)->update([
				'start_date'         => $start_date,
				'p_I_live'           => $phase1_end_date,
				'p_II_live'          => $phase2_end_date,
				'warrenty_period'    => $Warrenty_period_end_date,
				'expected_resources' => Input::get('resources'),
				'warranty_days'      => Input::get('Warrenty-days'),
				'holidays'           => Input::get('Warrenty-period-holiday')
				]);

			if(isset($data['phase']))
			{
				
				foreach ($data['phase'] as $key => $phase_data) {
					$total_designation_hrs=[];
					$all_designation_row_id=[];
					
					
					if($phase_data['spent_days']=='')
						$phase_data['spent_days']=0;
					$phase_id       = $phase_data['phase_id'];
					$spent_days		=$phase_data['spent_days'];
					$update_phase_day=$phase_time->where('project_id',$request->id)->where('ph_id',$phase_id)->update(["spent_days"=>$spent_days]);
					foreach($phase_data as $phase_key => $phase_value)
					{
						if(is_array($phase_value))
						{
							foreach($phase_value as $phase_detail_key => $phase_detail_value)
							{

								foreach ($phase_detail_value as $designation => $designation_info) {
									if(is_array($designation_info))
									{
										$row_id=$designation_info['row_id'];

										$d_id=$designation_info['d_id'];
										$hours=$designation_info['per_day_hours'];
										if($d_id=='')
											$d_id=0;
										if($hours=='')
											$hours=0;
										$actual_hrs=$hours * $spent_days;
										if(array_key_exists ( $d_id, $total_designation_hrs ))
											$total_designation_hrs[$d_id]+=$hours;
										else
											$total_designation_hrs[$d_id]=$hours;
										
										if($row_id=='0'){

											$get_row_id = $phase_individual_resource->insertGetId(
												['project_id' => $request->id,
												'ph_id' => $phase_id,
												'd_id' => $d_id,
												'spent_hrs' => $hours,
												'actual_hrs' => $actual_hrs]
												);
											array_push($all_designation_row_id, $get_row_id);
										}
										else
										{	
											$update_designation_hrs=$phase_individual_resource->where('id',$row_id)->update([
												"spent_hrs"=>$hours,
												"actual_hrs"=>$actual_hrs]);
											array_push($all_designation_row_id, $row_id);
										}
									}
								}
							}
						}
					}

					$delete_designation=$phase_individual_resource->where('project_id',$request->id)
					->where('ph_id',$phase_id)->whereNotIn('id', $all_designation_row_id)->delete();
					foreach ($total_designation_hrs as $d_id => $total_hrs) {

						$update_total_designation_hrs=$total_estimated_hrs->where('p_id',$request->id)->where('d_id',$d_id)
						->update(['hrs'=>$total_hrs]);
					}
					
				}
			}
		}
		// create Entry //
		else {


			$phase               = new Phases;
			$phase_time          = new PhaseTime;
			$individual_resource = new PhaseIndividualResource;
			if(isset($data['phase']))
			{

				foreach ($data['phase'] as $key => $phase_data) {

					$total_designation_hrs=[];
					$phase_id       = $phase_data['phase_id'];
					if($phase_data['spent_days']=='')
						$phase_data['spent_days']=0;

					$spent_days		=$phase_data['spent_days'];
					$insert_phase_days=DB::table('phase_times')->insert(
						['project_id' => $request->id,
						'ph_id' => $phase_id,
						'spent_days'=>$spent_days
						]
						);

					foreach($phase_data as $phase_key => $phase_value)
					{
						if(is_array($phase_value))
						{
							foreach($phase_value as $phase_detail_key => $phase_detail_value)
							{

								foreach ($phase_detail_value as $designation => $designation_info) {
									if(is_array($designation_info))
									{
										$row_id=$designation_info['row_id'];
										$d_id=$designation_info['d_id'];
										$hours=$designation_info['per_day_hours'];
										if($d_id=='')
											$d_id=0;
										if($hours=='')
											$hours=0;
										$actual_hrs=$hours * $spent_days;
										if(array_key_exists ( $d_id, $total_designation_hrs ))
											$total_designation_hrs[$d_id]+=$hours;
										else
											$total_designation_hrs[$d_id]=$hours;
										

										$get_row_id = $phase_individual_resource->insertGetId(
											['project_id' => $request->id,
											'ph_id' => $phase_id,
											'd_id' => $d_id,
											'spent_hrs' => $hours,
											'actual_hrs' => $actual_hrs]
											);
										
										
									}
								}
							}
						}
					}
					foreach ($total_designation_hrs as $d_id => $total_hrs) {

						$total_estimated_hrs->p_id=$request->id;
						$total_estimated_hrs->d_id=$d_id;
						$total_estimated_hrs->hrs=$total_hrs;
					}
				}
			}	
			$project_detail                  = new ProjectDetail;
			$project_detail->project_id      = $request->id;
			$project_detail->start_date      = $start_date;
			$project_detail->p_I_live        = $phase1_end_date;
			$project_detail->p_II_live       = $phase2_end_date;
			$project_detail->warrenty_period = $Warrenty_period_end_date;
			//$date                               = Input::get('Warrenty-period-end');
			$project_detail->expected_resources = Input::get('resources');
			$project_detail->warranty_days      = Input::get('Warrenty-days');
			$project_detail->holidays           = Input::get('Warrenty-period-holiday');
			$project_detail->save();

			$add_project=AddProject::where('project_id',$request->id)->update(['status_id' => 1]);
			/************************Populate planning data**********************/


			$phase               = new Phases;
			$phase_time          = new PlanPhaseTime;
			$individual_resource = new PlanPhaseResource;
			/*echo json_encode($data['phase']);
			exit();*/
			$editvar  = PlanProjectDetail::where('project_id', $request->id)->get();
			$editvar1 = PlanPhaseTime::where('project_id', $request->id)->get();
			$editvar2 = PlanPhaseResource::where('project_id', $request->id)->get();
			$phase      = new Phases;
			$phase_time = new PlanPhaseTime;
			$phase_individual_resource=new PlanPhaseResource;
			$total_estimated_hrs=new TotalPlanHrs;
			if (!(count($editvar) && count($editvar1) && count($editvar2)))
			{
				if(isset($data['phase']))
				{

					foreach ($data['phase'] as $key => $phase_data) {

						$total_designation_hrs=[];
						$phase_id       = $phase_data['phase_id'];
						if($phase_data['spent_days']=='')
							$phase_data['spent_days']=0;

						$spent_days		=$phase_data['spent_days'];
						$insert_phase_days=DB::table('plan_phase_times')->insert(
							['project_id' => $request->id,
							'ph_id' => $phase_id,
							'spent_days'=>$spent_days
							]
							);
						

						foreach($phase_data as $phase_key => $phase_value)
						{
							if(is_array($phase_value))
							{

								foreach($phase_value as $phase_detail_key => $phase_detail_value)
								{
									foreach ($phase_detail_value as $designation => $designation_info) {

										if(is_array($designation_info))
										{
											$row_id=$designation_info['row_id'];
											$d_id=$designation_info['d_id'];
											$hours=$designation_info['per_day_hours'];
											if($d_id=='')
												$d_id=0;
											if($hours=='')
												$hours=0;
											$actual_hrs=$hours * $spent_days;
											if(array_key_exists ( $d_id, $total_designation_hrs ))
												$total_designation_hrs[$d_id]+=$hours;
											else
												$total_designation_hrs[$d_id]=$hours;


											$get_row_id = $individual_resource->insertGetId(
												['project_id' => $request->id,
												'ph_id' => $phase_id,
												'd_id' => $d_id,
												'spent_hrs' => $hours,
												'actual_hrs' => $actual_hrs]
												);


										}
									}
								}
							}
						}
						foreach ($total_designation_hrs as $d_id => $total_hrs) {

							$total_estimated_hrs->p_id=$request->id;
							$total_estimated_hrs->d_id=$d_id;
							$total_estimated_hrs->hrs=$total_hrs;
						}
					}
				}

				$project_detail                  = new PlanProjectDetail;
				$project_detail->project_id      = $request->id;
				$project_detail->start_date      = $start_date;
				$project_detail->p_I_live        = $phase1_end_date;
				$project_detail->p_II_live       = $phase2_end_date;
				$project_detail->warrenty_period = $Warrenty_period_end_date;
			//$date                               = Input::get('Warrenty-period-end');
				$project_detail->expected_resources = Input::get('resources');
				$project_detail->warranty_days      = Input::get('Warrenty-days');
				$project_detail->holidays           = Input::get('Warrenty-period-holiday');
				$project_detail->save();
			}

			/********Ends here*************/

		}
		return redirect()->route('store-project');

	}
	
	/*public function test(Request $request)
	{
$success=0;
$errormsg="";
$filename=$request->file('upload_excel')->getPathName();
$file=$request->file('upload_excel');
$filesize=$request->file('upload_excel')->getClientSize();
 //Display File Extension
$file_extension=$file->getClientOriginalExtension();

   if($file_extension=="xlsx" || $file_extension=="xls")  
   { 
if($filesize > 0)
 {

$success=1;
	 $target_dir = public_path("uploads");
 	$target_file_name = "Nilesh".'_contactlist.xls';

    if ($request->file('upload_excel')->move($target_dir,$target_file_name)) {
    	

//  Read your Excel workbook
try {
    $inputFileType = PHPExcel_IOFactory::identify($target_dir."/".$target_file_name);
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    $objPHPExcel = $objReader->load($target_dir."/".$target_file_name);
} catch(Exception $e) {
    die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

//  Get worksheet dimensions
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
$alphabet = range('A', 'Z');
echo array_search($highestColumn, $alphabet)+1; // returns 3


//  Loop through each row of the worksheet in turn
for ($row = 1; $row <= $highestRow; $row++){ 
    //  Read a row of data into an array
    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                                    NULL,
                                    TRUE,
                                    FALSE);
   echo json_encode($rowData);
    //  Insert row data array into your database of choice here
}
exit();
 }
 }
 else
 {
 	$success=0;
 	$errormsg="File size is zero";
 }
}
else
{
	$success=0;
 	$errormsg="Not a valid extension";
}

unlink($target_dir."//".$target_file_name);
 return response()->json([
	'success'=>$success,
	'ErrorMsg'=>$errormsg
	]);

	}
	*/

	function getminutes($date_array)
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
	public function test()
	{
    	$todays_date=date('Y-m-d');
		if(date('N')== 0 || date('N')== 6)
			exit();
		$escalation_report=array();
		$escalation_report['timesheet_for_today']=DB::table('day_times')->where('date',$todays_date)->distinct('user_id')->count('user_id');
		$escalation_report['total_user']=DB::table('users')->count();
		$escalation_report['efficient_user_count']=0;
		$escalation_report['beyond_estimate']=0;
		$escalation_report['beyond_estimate_project_list']=array();
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
			$project_name=DB::table('add_projects')->where('project_id',$value->project_id)->get();
			$project_name=$project_name[0]->project_name;
			$project_total_hrs=DB::table('day_times')->where('project_name',$value->project_id)->lists('hrs_locked');
			$project_estimated_hrs=DB::table('phase_individual_resources')->where('project_id',$value->project_id)->lists('actual_hrs');
			$project_total_hrs=(json_decode(json_encode( $project_total_hrs), true));
			$project_estimated_hrs=(json_decode(json_encode( $project_estimated_hrs), true));
			if($this->getminutes( $project_total_hrs)>$this->getminutes( $project_estimated_hrs))
			{
				$escalation_report['beyond_estimate']++;
				array_push($escalation_report['beyond_estimate_project_list'],$project_name);

			}
			
		}

		$timesheetuser_for_today= DB::table('day_times')->distinct('user_id')->where('date',$todays_date)->select('user_id')->get();
		$user_array=array();
		foreach($timesheetuser_for_today as $key=>$value)
			array_push($user_array,$value->user_id);
		$escalation_report['timesheet_not_submitted'] = DB::table('users')->
		whereNotIn('user_id', $user_array)->select('first_name','last_name')->get();

echo "Today's date: ".date('d-m-Y')."<br><br>";
echo "Total timesheets submitted, today: ".$escalation_report["timesheet_for_today"]."<br><br>";
echo "How many total users on the platform: ".$escalation_report["total_user"]."<br><br>";
echo "How many users submitted Timesheets for 6+ hours: ".$escalation_report["efficient_user_count"]."<br><br>";
echo 'Number of projects whereby actuals have exceeded the estimate: '.$escalation_report["beyond_estimate"]."<br>";
if($escalation_report["beyond_estimate"]>0)
{
	echo "Project names:<span style='display:block;margin-left:15px;'>";
	foreach($escalation_report["beyond_estimate_project_list"] as $key=>$value)
	{
		$numbering=$key+1;
 	echo "$numbering. $value<br>";
	}
	echo "</span><br><br>";
}

echo "Who did NOT submit a Timesheet:<span style='display:block;margin-left:15px;'>";
 foreach($escalation_report['timesheet_not_submitted'] as $key=>$value)
 {
 	$numbering=$key+1;
 	echo "$numbering. $value->first_name $value->last_name<br>";
 }
echo "</span><b>Total: ".count($escalation_report['timesheet_not_submitted'])."<b>";
	}


/*It’s expected that you will review the below in detail and:
a) Ensure that it matches up with your understanding of what these individuals are working on.
b) Escalate and attend to any !Alerts below.

TODAY’S DATE: xx/xx/xx
This email was sent at: Time

Project Name: xxx
Team-members that logged time today: [List names]
Total time logged today (all designations): x hours
Time-sheets missing (for today): [List names]
Estimated hours (all designations):​ x hours​
Time tracked to-date (all designations): x hours
Estimated project end-date: Date
!Alert: Time tracked to-date is higher than estimate!
!Alert: Estimated project end-date has passed!
!Alert: Your estimated project end-date is within 10-15 working days from today (at min. 80 working hours for 1 resource). Please review your estimated hours (all designations) vs. time tracked to-date (all designations) in consideration of the timeline remaining/activities still pending on this project.!

(Repeat same format as above for all other projects being managed by this PM)

Note: Estimated hours represented above do NOT incl. warranty period.

*/
