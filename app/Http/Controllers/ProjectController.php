<?php

namespace App\Http\Controllers;

use App\AddProject;
use App\Http\Controllers\Controller;
use App\PlanProjectDetail;
use App\ProjectDesignation;
use App\ProjectDetail;
use App\SelfProject;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Http\Request as RequestHttp;
use Input;
use Redirect;
use Response;
use Session;

class ProjectController extends Controller {

	/**
	 * Display lists of projects.
	 *
	 * @param  int  $user_id
	 * @return view
	 */
	public function getProject($user_id) {
		$session         = Session::get('user')[0]['role_id'];
		$session_user_id = Session::get('user')[0]['user_id'];
		if (($session == 1 || $session == 2) && ($session_user_id == $user_id)) {

			// display the projects which are assigned to logged-in user on this view
			$project_info = SelfProject::distinct()->select('project_id')->where('user_id', $session_user_id)->get();
			$projects     = [];
			$client_name  = [];
			$designation  = [];

			for ($i = 0; $i < count($project_info); $i++) {
				$current        = $project_info[$i]->project_id;
				$designation_id = SelfProject::select('designation_id')->where('project_id', $current)->where('user_id', $session_user_id)->get();
				$temp           = '';
				$project_name   = DB::table('add_projects')->select('project_name', 'client_name')->where('project_id', $project_info[$i]->project_id)->get();
				foreach ($designation_id as $id) {
					$designation_name = ProjectDesignation::select('d_name')->where('d_id', $id->designation_id)->get()->first()->d_name;
					if ($designation_name == "BE_Developer") {
						$designation_name = "BED";
					} else if ($designation_name == "FE_Developer") {
						$designation_name = "FED";
					} else if ($designation_name == "Tester") {
						$designation_name = "QA";
					} else if ($designation_name == "Project Manager") {
						$designation_name = "PM";
					} else if ($designation_name == "Designer") {
						$designation_name = "Designer";
					} else if ($designation_name == "Tech Lead") {
						$designation_name = "TL";
					}

					if (strlen($temp) == 0) {
						$temp = $designation_name;
					} else {

						$temp = $temp.",".$designation_name;
					}
				}

				array_push($designation, $temp);
				array_push($client_name, $project_name[0]->client_name);
				array_push($projects, $project_name[0]->project_name);
			}

			return view('project/myProject', compact('projects', 'designation', 'client_name'));
		} else {
			return Redirect::to('/');
		}
	}

	/**
	 * Store the newly created projects.
	 *
	 * @param  RequestHttp  $request
	 * @return controller function
	 */
	public function storeProject(RequestHttp $request) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1 || $session == 2) {
			$this->validate($request, [
				"project_name" => "required",
				"client_name"  => "required"
				]);

			$store_project                = new AddProject;		
			$store_project->project_name = strtoupper(Input::get('project_name'));
			$store_project->client_name   = strtoupper(Input::get('client_name'));
			$store_project->status_id=Input::get('status_id');

			$store_project->save();

			$projects  = $store_project->select('project_id', 'project_name')->orderBy('project_id', 'desc')->get();
			$projectId = $store_project->id;

			return redirect()->route('store-project', ['id' => $projectId]);
			// return app('App\Http\Controllers\ProjectController')->backProject()->with('id', $projectId);
		}
	}

	/**
	 * Display lists of projects on back click.
	 *
	 * @return view
	 */
	public function backProject() {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1 || $session == 2) {

			$user_id        = Session::get('user')[0]['user_id'];
			$pname          = AddProject::select('project_name')->first();
			$projects       = AddProject::select('project_id', 'project_name', 'client_name','status_id')->where('is_deleted',0)->where('is_archived',0)->orderBy('project_id', 'desc')->get();
			foreach($projects as $key=>$value)
			{
				$set_plan = PlanProjectDetail::where('project_id', $value->project_id)->get();
				$set_estimate = ProjectDetail::where('project_id', $value->project_id)->get();
				if(count($set_plan)==0)
					$value->planning_status=0;
				else
					$value->planning_status=1;
				if(count($set_estimate)==0)
					$value->estimation_status=0;
				else
					$value->estimation_status=1;

			}
			
			$myselfproject  = DB::table('self_projects')->
			join('add_projects','add_projects.project_id','=','self_projects.project_id')->
			distinct('add_projects.project_id')->select('add_projects.project_id','add_projects.status_id')->where('self_projects.user_id', $user_id)->get();
			$my_project     = array();
			$my_designation = array();

			foreach ($myselfproject as $key => $value) {
				array_push($my_project, $value->project_id);
				$set_plan = PlanProjectDetail::where('project_id', $value->project_id)->get();
				$set_estimate = ProjectDetail::where('project_id', $value->project_id)->get();
				if(count($set_plan)==0)
					$value->planning_status=0;
				else
					$value->planning_status=1;
				if(count($set_estimate)==0)
					$value->estimation_status=0;
				else
					$value->estimation_status=1;
				$getdesignation = DB::table('self_projects')
				->join('project_designations', 'self_projects.designation_id', '=', 'project_designations.d_id')
				->select('project_designations.d_name', 'self_projects.project_id')	->
				where('self_projects.project_id', $value->project_id)->
				where('self_projects.user_id', $user_id)             ->get();
				$temp          = 0;
				$mydesignation = '';
				//	echo json_encode($getdesignation)."<br>";
				foreach ($getdesignation as $key => $value) {
					$designation_name = $value->d_name;
					if ($designation_name == "BE_Developer") {
						$designation_name = "BED";
					} else if ($designation_name == "FE_Developer") {
						$designation_name = "FED";
					} else if ($designation_name == "Tester") {
						$designation_name = "QA";
					} else if ($designation_name == "Project Manager") {
						$designation_name = "PM";
					} else if ($designation_name == "Designer") {
						$designation_name = "Designer";
					} else if ($designation_name == "Tech Lead") {
						$designation_name = "TL";
					}

					if ($temp == 0) {
						$mydesignation = $designation_name;
					} else {
						$mydesignation = $mydesignation.", ".$designation_name;
					}
					$temp++;
				}
				array_push($my_designation, $mydesignation);
			}
			$myassigned_project_id=array();
			$myassigned_project = array();
			foreach ($projects as $key => $value) {
				$new_key = array_search($value->project_id, $my_project);

				//echo $new_key."-->".$value->project_id."<br>";
				if (strlen($new_key) > 0) {
					array_push($myassigned_project_id, $value->project_id);
					$value->designation_name = $my_designation[$new_key];
					array_push($myassigned_project, $value);
					unset($projects[$key]);
				}
			}

			
			/*******************************
			project status

			Estimates=1
			live-projects=2
			live-ongoing=3
			completed=4

			 **********************************/
			$estimates_project    = AddProject::select('project_id', 'project_name', 'client_name','status_id')->orderBy('project_id', 'desc')->where('status_id', '1')->where('is_deleted',0)->where('is_archived',0)->get();
			$live_project         = AddProject::select('project_id', 'project_name', 'client_name','status_id')->orderBy('project_id', 'desc')->where('status_id', '2')->where('is_deleted',0)->where('is_archived',0)->get();
			$live_ongoing_project = AddProject::select('project_id', 'project_name', 'client_name','status_id')->orderBy('project_id', 'desc')->where('status_id', '3')->where('is_deleted',0)->where('is_archived',0)->get();
			$completed_project    = AddProject::select('project_id', 'project_name', 'client_name','status_id')->orderBy('project_id', 'desc')->where('status_id', '4')->where('is_deleted',0)->where('is_archived',0)->get();

			$archive_project    = AddProject::select('project_id', 'project_name', 'client_name','status_id')->orderBy('project_id', 'desc')->where('is_archived', '1')->where('is_deleted','0')->get();
			
			$my_project=array();
			$my_project_key=array();
			foreach ($estimates_project as $key => $value) {
				$set_plan = PlanProjectDetail::where('project_id', $value->project_id)->get();
				$set_estimate = ProjectDetail::where('project_id', $value->project_id)->get();
				if(count($set_plan)==0)
					$value->planning_status=0;
				else
					$value->planning_status=1;
				if(count($set_estimate)==0)
					$value->estimation_status=0;
				else
					$value->estimation_status=1;
				$new_key = array_keys($myassigned_project_id,$value->project_id);
				if (count($new_key)>0) {
					$value->designation_name=$myassigned_project[$new_key[0]]->designation_name;
					$value->is_myproject = 'Yes';
					array_push($my_project, $value);
					array_push($my_project_key, $key);
				} else {

					$value->is_myproject = 'No';

				}

			}
			foreach($my_project_key as $value)
				unset($estimates_project[$value]);
			foreach ($my_project as $key => $value) {
				$estimates_project->prepend($value);
			}
			
			$my_project=array();
			$my_project_key=array();
			foreach ($live_project as $key => $value) {
				$set_plan = PlanProjectDetail::where('project_id', $value->project_id)->get();
				$set_estimate = ProjectDetail::where('project_id', $value->project_id)->get();
				if(count($set_plan)==0)
					$value->planning_status=0;
				else
					$value->planning_status=1;
				if(count($set_estimate)==0)
					$value->estimation_status=0;
				else
					$value->estimation_status=1;
				$new_key = array_keys($myassigned_project_id,$value->project_id);
				if (count($new_key)>0) {
					$value->designation_name=$myassigned_project[$new_key[0]]->designation_name;
					$value->is_myproject = 'Yes';
					array_push($my_project, $value);
					array_push($my_project_key, $key);
				} else {

					$value->is_myproject = 'No';

				}
			}
			foreach($my_project_key as $value)
				unset($live_project[$value]);
			foreach ($my_project as $key => $value) {
				$live_project->prepend($value);
			}
			
			$my_project=array();
			$my_project_key=array();
			foreach ($live_ongoing_project as $key => $value) {
				$set_plan = PlanProjectDetail::where('project_id', $value->project_id)->get();
				$set_estimate = ProjectDetail::where('project_id', $value->project_id)->get();
				if(count($set_plan)==0)
					$value->planning_status=0;
				else
					$value->planning_status=1;
				if(count($set_estimate)==0)
					$value->estimation_status=0;
				else
					$value->estimation_status=1;
				$new_key = array_keys($myassigned_project_id,$value->project_id);
				if (count($new_key)>0) {
					$value->designation_name=$myassigned_project[$new_key[0]]->designation_name;
					$value->is_myproject = 'Yes';
					array_push($my_project, $value);
					array_push($my_project_key, $key);
				} else {

					$value->is_myproject = 'No';

				}
			}
			
			foreach($my_project_key as $value)
				unset($live_ongoing_project[$value]);
			foreach ($my_project as $key => $value) {
				$live_ongoing_project->prepend($value);
			}
			
			$my_project=array();
			$my_project_key=array();
			foreach ($completed_project as $key => $value) {
				$set_plan = PlanProjectDetail::where('project_id', $value->project_id)->get();
				$set_estimate = ProjectDetail::where('project_id', $value->project_id)->get();
				if(count($set_plan)==0)
					$value->planning_status=0;
				else
					$value->planning_status=1;
				if(count($set_estimate)==0)
					$value->estimation_status=0;
				else
					$value->estimation_status=1;
				$new_key = array_keys($myassigned_project_id,$value->project_id);
				if (count($new_key)>0) {
					$value->designation_name=$myassigned_project[$new_key[0]]->designation_name;
					$value->is_myproject = 'Yes';
					array_push($my_project, $value);
					array_push($my_project_key, $key);
				} else {

					$value->is_myproject = 'No';

				}
			}
			foreach($my_project_key as $value)
				unset($completed_project[$value]);
			foreach ($my_project as $key => $value) {
				$completed_project->prepend($value);
			}

			$my_project=array();
			$my_project_key=array();
			foreach ($archive_project as $key => $value) {
				$set_plan = PlanProjectDetail::where('project_id', $value->project_id)->get();
				$set_estimate = ProjectDetail::where('project_id', $value->project_id)->get();
				if(count($set_plan)==0)
					$value->planning_status=0;
				else
					$value->planning_status=1;
				if(count($set_estimate)==0)
					$value->estimation_status=0;
				else
					$value->estimation_status=1;
				$new_key = array_keys($myassigned_project_id,$value->project_id);
				if (count($new_key)>0) {
					$value->designation_name=$myassigned_project[$new_key[0]]->designation_name;
					$value->is_myproject = 'Yes';
					array_push($my_project, $value);
					array_push($my_project_key, $key);
				} else {

					$value->is_myproject = 'No';

				}
			}
			foreach($my_project_key as $value)
				unset($archive_project[$value]);
			foreach ($my_project as $key => $value) {
				$archive_project->prepend($value);
			}

			return view('project/projectDetail')->with(['myproject' => $myassigned_project, 'projects' => $projects, 'estimates_project' => $estimates_project, 'live_project' => $live_project, 'live_ongoing_project' => $live_ongoing_project, 'completed_project' => $completed_project]);

		} else {
			return Redirect::to('/');
		}
	}

	public function changeStatus(RequestHttp $request) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			$project_status=AddProject::where('project_id',$request->project_id)->update(['status_id' => $request->project_status]);
			return response()->json([
				'success' => 1
				]);
		}
		else
			return response()->json([
				'success' => 0
				]);
	}


	public function editProject(Request $request) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			// fetch the data of requested id and display it onto pop-up view
			if ($request->ajax()) {
				$project_data	= AddProject::find($request->header('id'));
				return Response($project_data);
			}
		} else {
			return Redirect::to('/');
		}
	}
	public function updateProject(Request $request) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			// fetch the data of requested id and display it onto pop-up view
			if ($request->ajax()) {
				$project_data             = AddProject::find($request->project_id);
				if(count($project_data)==1)
				{
					$project_data->project_name=$request->project_name;
					$project_data->client_name=$request->client_name;
					$project_data->save();
					$success=1;
				}
				else{
					$success=0;
				}


				return response()->json([
					'success' => $success
					]);
			}
		} else {
			return Redirect::to('/');
		}
	}
	/**
	 *
	 *
	*/
	public function deleteProject(Request $request,$id)
	{
		$session = Session::get('user')[0]['role_id'];
		$success=0;
		if ($session == 1) 
		{
			if($request->ajax())
			{
				$project_detail=AddProject::where('project_id',$id)->get();
				$delete_project= AddProject::where('project_id',$id)->update([
					'is_deleted'=>1]);
				$user_name=Session::get('user')[0]['first_name']." ".Session::get('user')[0]['last_name'];

				if($delete_project)
				{
					$success=1;
					$project_member=DB::table('self_projects')->join('users','self_projects.user_id','=','users.user_id')->select('username')->where('project_id',$id)->distinct()->get();
					$user_email=array();
					foreach($project_member as $key=>$value)
						array_push($user_email, $value->username);
					array_push($user_email,'projectmanagement@prdxn.com');
					$projectowner_email=DB::table('users')->
					join('add_projects','users.user_id','=','add_projects.created_by')->
					select('users.username')->where('add_projects.project_id',$id)->get();
					if(!in_array($projectowner_email[0]->username,$user_email))
						array_push($user_email,$projectowner_email[0]->username);


					Mail::send('notification/deleteNotification', ['project_detail'=>$project_detail,'user_name'=>$user_name], function ($message) use ($user_email)
					{

						$message->from('nilesh.vidhate.prdxn@gmail.com', "ITTT Admin");

						$message->to($user_email);
						
						$message->subject("PROJECT DELETE NOTIFICATION");
						/* $message->replyTo($_POST['timesheetdata']['key'], $name = $_POST['timesheetdata'][0]["name"]);*/
					});
				}
			}
		}
		return response()->json([
			'success'=>$success            
			]);
	}


	public function archiveProject(Request $request,$id)
	{
		$session = Session::get('user')[0]['role_id'];
		$success=0;
		if ($session == 1 || $session == 2) 
		{
			if($request->ajax())
			{
				$project_detail=AddProject::where('project_id',$id)->get();
				$delete_project= AddProject::where('project_id',$id)->update([
					'is_archived'=>1]);
				$user_name=Session::get('user')[0]['first_name']." ".Session::get('user')[0]['last_name'];

				if($delete_project)
				{
					$success=1;
					$project_member=DB::table('self_projects')->join('users','self_projects.user_id','=','users.user_id')->select('username')->where('project_id',$id)->distinct()->get();
					$user_email=array();
					foreach($project_member as $key=>$value)
						array_push($user_email, $value->username);

					array_push($user_email,'projectmanagement@prdxn.com');
					$projectowner_email=DB::table('users')->
					join('add_projects','users.user_id','=','add_projects.created_by')->
					select('users.username')->where('add_projects.project_id',$id)->get();
					if(!in_array($projectowner_email[0]->username,$user_email))
						array_push($user_email,$projectowner_email[0]->username);

					Mail::send('notification/archiveNotification', ['project_detail'=>$project_detail,'user_name'=>$user_name], function ($message) use ($user_email)
					{

						$message->from('nilesh.vidhate.prdxn@gmail.com', "ITTT Admin");

						$message->to($user_email);
						$message->subject("PROJECT ARCHIVE NOTIFICATION");
						/* $message->replyTo($_POST['timesheetdata']['key'], $name = $_POST['timesheetdata'][0]["name"]);*/

					});
				}
			}
		}
		return response()->json([
			'success'=>$success            
			]);
	}
}
