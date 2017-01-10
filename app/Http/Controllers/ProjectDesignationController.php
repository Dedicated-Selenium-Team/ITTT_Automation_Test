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
use Redirect;

use Session;

class ProjectDesignationController extends Controller {
	/**
	 * Display Project designation listing view.
	 *
	 * @param $id = null
	 * @return redirect to route
	 */
	public function index($id = null) {
		$session = Session::get('user')[0]['role_id'];

		if ($session == 1 || $session == 2) {
			// Once the estimation is done for particular project then the project would be displayed into dropdown list with the designations

			$instance     = new AddProject;
			$new_instance = new AddProject;

			$getData         = ProjectDetail::all();
			$project_id      = $new_instance->lists('project_id')->toArray();
			$project_list    = array();
			$project_id_list = array();
			foreach ($project_id as $key => $value) {
				$add_project_name = DB::table('add_projects')->
				select('add_projects.project_name')          ->where('add_projects.project_id', $value)->get();
				if (count($add_project_name) > 0) {
					array_push($project_list, $add_project_name[0]);
				}
			}

			//$list_name = array(''          => 'Choose a Project...');
			$list_name = array();
			foreach ($project_list as $key => $value) {
				foreach ($value as $key       => $value1) {
					array_push($list_name, $value1);
				}
			}
			// fetch all the designations from database and dispal them into dropdown menu
			$designation = array('' => 'Choose your Designation/Role on this Project...')+ProjectDesignation::lists('d_name', 'd_id')->toArray();
			// echo json_encode($project_id);

			// echo json_encode($list_name);
			return view('/project_designation/index', compact('designation', 'list_name', 'p_name', 'project_list', 'project_id', 'id'));
		} else {
			return Redirect::to('/');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param string $name
	 * @param int $id = 'all'
	 * @return json object
	 */
	public function create($name, $id) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1 || $session == 2) {

			$self_project = new SelfProject;

			// fetch the selected project details with the selected designation and display them into particular accordion window

			$project_id = $name;
			$projects   = $self_project->where('project_id', $project_id)->where('designation_id', $id)->get();
			$projects   = DB::table('self_projects')->select('self_projects.*')
			                                      ->join('users', 'users.user_id', '=', 'self_projects.user_id')
			                                      ->where('project_id', $name)
			                                      ->where('designation_id', $id)->get();

			$user_id = $self_project->select('user_id')->where('project_id', $project_id)->where('designation_id', $id)->get();
			$user_id = DB::table('self_projects')->select('self_projects.user_id')
			                                     ->join('users', 'users.user_id', '=', 'self_projects.user_id')
			                                     ->where('self_projects.project_id', $name)
			                                     ->where('self_projects.designation_id', $id)
			                                     ->get();
			$estimate_hrs = PhaseIndividualResource::select('actual_hrs')->where('project_id', $project_id)->where('d_id', $id)->where('ph_id', '<', 8)->get();

			// Calculate the total estimated hrs for the particular designation
			$add = 0;
			for ($i = 0; $i < count($estimate_hrs); $i++) {
				$current = $estimate_hrs[$i]->actual_hrs;
				$add     = $add+$current;
			}

			// Calculate the total planned hrs for the particular designation
			$planning_hrs = PlanPhaseResource::select('actual_hrs')->where('project_id', $project_id)->where('d_id', $id)->where('ph_id', '<', 8)->get();
			$add_planning = 0;
			for ($i = 0; $i < count($planning_hrs); $i++) {
				$current      = $planning_hrs[$i]->actual_hrs;
				$add_planning = $add_planning+$current;
			}
			$name_array    = [];
			$timesheet_hrs = [];

			// fetch the names of the users who are assigned for the project with the selected designation

			for ($i = 0; $i < count($user_id); $i++) {
				$current_u_id = $user_id[$i]->user_id;

				$u_name = User::select('first_name')->where('user_id', $current_u_id)->get()->first()->first_name;

				$hrs = DayTime::select('hrs_locked')->where('user_id', $current_u_id)->where('project_name', $name)
				                                    ->where('d_id', $id)->get();

				//Calculate total timesheet hrs for particular user for particular project designation
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
					'name'          => $name_array,
					'projects'      => $projects,
					'hrs'           => $add,
					'plan_hrs'      => $add_planning,
					'timesheet_hrs' => $timesheet_hrs
				]);

		} else {
			return Redirect::to('/');
		}
	}
	public function getDesignation() {
		$designation_name = array();
		$designation      = ProjectDesignation::select('d_name')->get();
		foreach ($designation as $key => $value) {
			array_push($designation_name, $value->d_name);
		}
		return response()->json([
				"designation" => $designation_name
			]);

	}

	public function getallhrs($project_id) {
		$total_estimate_hrs = PhaseIndividualResource::select('actual_hrs')->where('project_id', $project_id)->where('ph_id', '<', 8)->sum('actual_hrs');
		$total_planning_hrs = PlanPhaseResource::select('actual_hrs')->where('project_id', $project_id)->where('ph_id', '<', 8)->sum('actual_hrs');
		$total_actual_hrs   = DayTime::select('hrs_locked')->where('project_name', $project_id)->sum('hrs_locked');
		if ($total_actual_hrs == null) {
			$total_actual_hrs = 0;
		}

		$end_date                      = DayTime::select('date')->orderBy('date', 'desc')->where('project_name', $project_id)->get()->first();
		$start_date                    = DayTime::select('date')->orderBy('date', 'asc')->where('project_name', $project_id)->get()->first();
		$all_hrs                       = array();
		$all_hrs['total_estimate_hrs'] = $total_estimate_hrs;
		$all_hrs['total_planning_hrs'] = $total_planning_hrs;
		$all_hrs['total_actual_hrs']   = $total_actual_hrs;

		if (count($start_date) == 0) {
			$start_date = 0;
			$end_date   = 0;
		} else {
			$start_datetimestamp = strtotime($start_date->date);
			$start_date          = date('d/m/Y', $start_datetimestamp);
			$end_datetimestamp   = strtotime($end_date->date);
			$end_date            = date('d/m/Y', $end_datetimestamp);

		}

		$all_hrs['start_date'] = $start_date;
		$all_hrs['end_date']   = $end_date;
		foreach ($all_hrs as $key => $value) {
			if (is_null($value)) {
				$all_hrs[$key] = 0;
			}
		}
		return response()->json([
				'all_hrs' => $all_hrs
			]);
	}
}
