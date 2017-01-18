<?php

namespace App\Http\Controllers;

use App\AddProject;

use App\DayTime;

use App\Http\Controllers\Controller;
use App\PhaseIndividualResource;
use App\PlanPhaseResource;
use App\ProjectDesignation;
use App\ProjectDetail;

use App\SelfProject;
use App\User;
use DB;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Session;

class MyselfProjectController extends Controller {

	/**
	 * Display the view for assign self projects.
	 *
	 * @return View
	 */
	public function index() {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1 || $session == 2) {
			$add_project     = new AddProject;
			$project_detail = new ProjectDetail;

			// Extract all the details of the projects whose estimation is done.
			$getData         = $project_detail->get();
			
			$project_id      = $add_project->where('is_archived','0')->where('is_deleted','0')->lists('project_id')->toArray();
			$project_list    = array();
			$remove_project=array();
			foreach ($project_id as $key => $value) {

				$add_project_name = $add_project->select('project_name')->where('project_id', $value)->get()->first();
				/*$add_project_id   = $add_project->select('project_id')->where('project_id', $value)->get()->first()->toArray();
				echo json_encode($add_project_id);
				exit();*/

				if($add_project_name)
					array_push($project_list, $add_project_name);
				else
					array_push($remove_project,$key);
				
			}
			foreach($remove_project as $key=>$value)
				unset($project_id[$value]);
			$project_id=array_values($project_id);

			$list_name = array('' => 'Choose a Project...');
			$list_id   = array();
			
			foreach ($project_list as $key => $value) {
				
				array_push($list_name, $value->project_name);
			}
			/*echo json_encode($project_list[0]);
			
*/
			$users_info  = $add_project->with('ProjectDetail')->get();
			$designation = array('' => 'Choose your Designation/Role on this Project...')+ProjectDesignation::lists('d_name', 'd_id')->toArray();
			return view('project/self', compact('designation', 'list_name',  'project_id', 'project_list'));
			//	return $designation;
		} else {
			return Redirect::to('/');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param string $name
	 * @param  int  $id, $req_hrs
	 * @return json object
	 */
	public function create($name, $id, $req_hrs) {
		//name is project id 15
		//id is project designation 1
		//req_hrs is %of hours 6.63
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1 || $session == 2) {
			$self_project    = new SelfProject;
			$session_user_id = Session::get('user')[0]['user_id'];

			//$projects        = $self_project->where('project_id', $name)->where('designation_id', $id)->get();

			$projects = DB::table('self_projects')->select('self_projects.*')
			->join('users', 'users.user_id', '=', 'self_projects.user_id')
			->where('self_projects.project_id', $name)
			->where('self_projects.designation_id', $id)->get();

			//got total users on that project
			//echo count($projects);
			/*$user_id         = $self_project->select('user_id')->where('project_id', $name)->where('designation_id', $id)->get();*/
			$user_id = DB::table('self_projects')->select('self_projects.user_id')
			->join('users', 'users.user_id', '=', 'self_projects.user_id')
			->where('self_projects.project_id', $name)
			->where('self_projects.designation_id', $id)
			->get();
			//user_id of that user
			$name_array    = [];
			$timesheet_hrs = [];
			$userid_array  = [];
			for ($userCount = 0; $userCount < count($user_id); $userCount++) {
				$current_u_id = $user_id[$userCount]->user_id;
				$u_name       = User::select('first_name')->where('user_id', $current_u_id)->get()->first()->first_name;

				$hrs = DB::table('day_times')->select('day_times.hrs_locked')->
				join('add_projects', 'day_times.project_name', '=', 'add_projects.project_id')
				->where('day_times.user_id', $current_u_id)->where('day_times.project_name', $name)->where('day_times.d_id', $id)->get();

				/* Calculate total timesheet hrs for particular user for particular project designation */
				$timesheet_add_hrs = 0;
				for ($j = 0; $j < count($hrs); $j++) {

					$timesheet_add_hrs += (float) $hrs[$j]->hrs_locked;
				}

				$timesheet_hrs[$userCount] = [
				"timesheet_hrs" => $timesheet_add_hrs
				];
				array_push($name_array, $u_name);
				array_push($userid_array, $current_u_id);

			}

			$estimate_hrs = PhaseIndividualResource::select('actual_hrs')->where('project_id', $name)->where('d_id', $id)->where('ph_id', '<', 8)->get();
			$planning_hrs = PlanPhaseResource::select('actual_hrs')->where('project_id', $name)->where('d_id', $id)->where('ph_id', '<', 8)->get();
			$estimate_add = 0;

			/* Calculate total estimated hrs */
			for ($i = 0; $i < count($estimate_hrs); $i++) {
				$estimate_add = $estimate_hrs[$i]->actual_hrs+$estimate_add;
			}

			/* Calculate total planning hrs */
			$planning_add = 0;
			for ($i = 0; $i < count($planning_hrs); $i++) {
				$planning_add = $planning_hrs[$i]->actual_hrs+$planning_add;
			}

			$current_user_name = User::select('first_name')->where('user_id', $session_user_id)->get()->first()->first_name;

			/*******Repetitive Users*******/
			$add_my_hrs   = $req_hrs;
			$check_my_hrs = 0;
			if (in_array($session_user_id, $userid_array)) {
				$my_hrs     = SelfProject::select('required_hrs')->where('user_id', $session_user_id)->where('project_id', $name)->where('designation_id', $id)->get()->first()->required_hrs;
				$add_my_hrs = $my_hrs+$add_my_hrs;
				foreach ($projects as $key => $value) {
					if ($session_user_id == $value->user_id) {
						$check_my_hrs = $value->required_hrs = $add_my_hrs;
					}
				}
			} else {
				array_push($name_array, $current_user_name);
				for ($i = $userCount; $i <= $userCount; $i++) {
					$timesheet_hrs[$i] = [
					"timesheet_hrs" => 0
					];
					$projects[count($projects)] = (object) array('required_hrs' => $add_my_hrs);
					//$projects[count($projects)] = (object) array('required_hrs' => $req_hrs);
				}
			}

			/*required hrs*/

			return response()->json([
				'hrs'           => $estimate_add,
				'plan_hrs'      => $planning_add,
				'required_hrs'  => $req_hrs,
				'user'          => $session_user_id,
				'projects'      => $projects,
				'name'          => $name_array,
				'names'         => $current_user_name,
				'timesheet_hrs' => $timesheet_hrs,
				'add_my_hrs'    => $check_my_hrs
				]);
		} else {
			return Redirect::to('/');
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return View
	 */
	public function store(Request $request) {
		$session_id     = Session::get('user')[0]['user_id'];
		$self_project   = new SelfProject;
		$project_name   = Input::get('project_name');
		$project_id     = $project_name;
		$designation_id = Input::get('designation_id');
		$check_my_hrs   = $self_project->where('user_id', $session_id)->where('project_id', $project_id)->where('designation_id', $designation_id)->get();
		if (count($check_my_hrs) > 0) {
			foreach ($check_my_hrs as $value)
				$required_hours = $value->required_hrs;
			$my_hours       = Input::get('req_hrs')+$required_hours;
			$update_hours   = $self_project->where('user_id', $session_id)->where('project_id', $project_id)->where('designation_id', $designation_id)->update(['required_hrs' => $my_hours]);
		} else {
			$self_project->user_id        = $request->id;
			$self_project->project_id     = $project_id;
			$self_project->designation_id = Input::get('designation_id');
			$self_project->required_hrs   = Input::get('req_hrs');
			$self_project->save();
		}
		// $my_project_count = $self_project->where('user_id', $session_id)->get();
		// $projects         = [];
		// $projectId        = [];
		// for ($i = 0; $i < count($my_project_count); $i++) {
		// 	$project_id   = $self_project->where('user_id', $session_id)->get()->first()->project_id;
		// 	$project_name = AddProject::where('project_id', $project_id)->get()->first();
		// 	array_push($projects, $project_name);
		// 	array_push($projectId, $project_id);
		// }
		return redirect()->route('store-project');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param string $name
	 * @param  int  $id
	 * @return json object
	 */
	public function show($name, $id) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1 || $session == 2) {
			$self_project = new SelfProject;

			$estimate_hrs = PhaseIndividualResource::select('actual_hrs')->where('project_id', $name)->where('d_id', $id)->where('ph_id', '<', 8)->get();
			$planning_hrs = PlanPhaseResource::select('actual_hrs')->where('project_id', $name)->where('d_id', $id)->where('ph_id', '<', 8)->get();
			$actual_hrs	=DayTime::select(DB::raw('SUM(hrs_locked) as actual_hrs'))
			->where('project_name',$name)->where('d_id',$id)->get();

			if($actual_hrs[0]->actual_hrs==null)
				$actual_hrs=0;
			else
				$actual_hrs=$actual_hrs[0]->actual_hrs;
			$estimate_add = 0;

			/* Calculate total estimated hrs */
			for ($i = 0; $i < count($estimate_hrs); $i++) {
				$estimate_add = $estimate_hrs[$i]->actual_hrs+$estimate_add;
			}

			/* Calculate total planning hrs */
			$planning_add = 0;
			for ($i = 0; $i < count($planning_hrs); $i++) {
				$planning_add = $planning_hrs[$i]->actual_hrs+$planning_add;
			}

			$projects = $self_project->where('project_id', $name)->where('designation_id', $id)->get();
			$projects = DB::table('self_projects')->select('self_projects.*')
			->join('users', 'users.user_id', '=', 'self_projects.user_id')
			->where('project_id', $name)
			->where('designation_id', $id)->get();
			//$user_id       = $self_project->select('user_id')->where('project_id', $project_id)->where('designation_id', $id)->get();
			$user_id = DB::table('self_projects')->select('self_projects.user_id')
			->join('users', 'users.user_id', '=', 'self_projects.user_id')
			->where('self_projects.project_id', $name)
			->where('self_projects.designation_id', $id)
			->get();
			$name_array    = [];
			$timesheet_hrs = [];

			/* find user name for particular assigned project */
			for ($i = 0; $i < count($user_id); $i++) {
				$current_u_id = $user_id[$i]->user_id;
				$u_name       = User::select('first_name')->where('user_id', $current_u_id)->get()->first()->first_name;
				$hrs          = DayTime::select('hrs_locked')->where('user_id', $current_u_id)->where('project_name', $name)
				->where('d_id', $id)->
				get();

				/* Calculate total timesheet hrs for particular user for particular project designation */
				$timesheet_add_hrs = 0;
				for ($j = 0; $j < count($hrs); $j++) {
					$timesheet_add_hrs = $hrs[$j]->hrs_locked+$timesheet_add_hrs;
				}
				$timesheet_hrs[$i] = [
				"timesheet_hrs" => $timesheet_add_hrs
				];
				array_push($name_array, $u_name);
			}

			return response()->json([
				'hrs'           => $estimate_add,
				'plan_hrs'      => $planning_add,
				'actual_hrs'      => $actual_hrs,
				'projects'      => $projects,
				'name'          => $name_array,
				'timesheet_hrs' => $timesheet_hrs,

				]);
		} else {
			return Redirect::to('/');
		}
	}
}
