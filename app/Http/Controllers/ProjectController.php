<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Project;
use App\ProjectResources;
use App\Client;
use App\User;
use Input;
use Redirect;
use DB;
use Response;
use Session;

class ProjectController extends Controller
{
    /**
     * Display a project list.
     *
     * @return Response
     */
    public function index()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1)
      {
        $project_info = Project::with('ProjectResources')->get();
        $users = User::select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))->lists('full_name', 'user_id');
        $clients = Client::select('clients.client_name', 'clients.client_id')->lists('client_name', 'client_id');

        return view('project/index', compact('project_info', 'users', 'clients'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Show the form for creating a new project.
     *
     * @return Response
     */
    public function create()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1)
      {
        $client = array('' => 'Please Select') + Client::lists('client_name','client_id')->toArray();
        $project_manager = User::join('user_details', 'users.user_id', '=', 'user_details.user_id')
        ->select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))
        ->where('user_details.designation_id', 3)->lists('full_name', 'user_id');

        $developer = User::join('user_details', 'users.user_id', '=', 'user_details.user_id')
        ->select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))
        ->where('user_details.designation_id', 1)->lists('full_name', 'user_id');

        $quality_analyst = User::join('user_details', 'users.user_id', '=', 'user_details.user_id')
        ->select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))
        ->where('user_details.designation_id', 2)->lists('full_name', 'user_id');

        $design_team = User::join('user_details', 'users.user_id', '=', 'user_details.user_id')
        ->select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))
        ->where('user_details.designation_id', 4)->lists('full_name', 'user_id');

        return view('project/create', compact('client', 'project_manager', 'developer', 'quality_analyst', 'design_team'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Store a newly created project in database.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1)
      {
        $inserted_id;
        // $this->validate($request, [
        //
        // ]);

        $project = new Project;
        $project->project_name = Input::get('project-name');
        $project->client_id = Input::get('client-id');
        $project->estimated_time = Input::get('estimated-time');
        $project->save();

        if($project->save()) {
          $inserted_id = $project->project_id;

          $resource_id = array();
          $designation_id = array();
          $resource_hours = array();

          if(Input::get('resource-id')) {
            foreach(Input::get('resource-id') as $id) {
              array_push($resource_id, $id);
            }

            foreach(Input::get('designation-id') as $id) {
              array_push($designation_id, $id);
            }

            foreach(Input::get('resource-hours') as $hours) {
              array_push($resource_hours, $hours);
            }

            foreach($resource_id as $key => $value) {
              $project_resources = new ProjectResources;
              $project_resources->project_id = $inserted_id;
              $project_resources->user_id = $value;
              $project_resources->designation_id = $designation_id[$key];
              $project_resources->hours = $resource_hours[$key];
              $project_resources->save();
            }
          }

        }

        return Redirect::to('/project-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Display the specified project.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified project.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $project = Project::with('ProjectResources')->find($id);
        $client = array('' => 'Please Select') + Client::lists('client_name','client_id')->toArray();
        $project_manager = User::join('user_details', 'users.user_id', '=', 'user_details.user_id')
        ->select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))
        ->where('user_details.designation_id', 3)->lists('full_name', 'user_id');

        $developer = User::join('user_details', 'users.user_id', '=', 'user_details.user_id')
        ->select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))
        ->where('user_details.designation_id', 1)->lists('full_name', 'user_id');

        $quality_analyst = User::join('user_details', 'users.user_id', '=', 'user_details.user_id')
        ->select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))
        ->where('user_details.designation_id', 2)->lists('full_name', 'user_id');

        $design_team = User::join('user_details', 'users.user_id', '=', 'user_details.user_id')
        ->select(DB::raw('concat (users.first_name," ",users.last_name) as full_name, users.user_id'))
        ->where('user_details.designation_id', 4)->lists('full_name', 'user_id');

        return view('project/edit', compact('project', 'client', 'project_manager', 'developer', 'quality_analyst', 'design_team'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Update the specified project in database.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $project_id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        // $this->validate($request, [
        //
        // ]);

        $project = Project::find($project_id);
        $project->project_name = Input::get('project-name');
        $project->client_id = Input::get('client-id');
        $project->estimated_time = Input::get('estimated-time');
        $project->save();

        if($project->save()) {

          $resource_id = array();
          $resource_hours = array();
          $designation_id = array();

          if(Input::get('resource-id')) {
            foreach(Input::get('resource-id') as $id) {
              array_push($resource_id, $id);
            }

            foreach(Input::get('designation-id') as $id) {
              array_push($designation_id, $id);
            }

            foreach(Input::get('resource-hours') as $hours) {
              array_push($resource_hours, $hours);
            }

            foreach($resource_id as $key => $value) {
              $project_resources = new ProjectResources;
              $project_resources->project_id = $project_id;
              $project_resources->user_id = $value;
              $project_resources->designation_id = $designation_id[$key];
              $project_resources->hours = $resource_hours[$key];
              $project_resources->save();
            }
          }

          $existing_resource_id = array();
          $existing_resource_hours = array();
          $existing_designation_id = array();

          if(Input::get('existing-resource-id')) {
            foreach(Input::get('existing-resource-id') as $id) {
              array_push($existing_resource_id, $id);
            }

            foreach(Input::get('existing-designation-id') as $id) {
              array_push($existing_designation_id, $id);
            }

            foreach(Input::get('existing-resource-hours') as $hours) {
              array_push($existing_resource_hours, $hours);
            }

            foreach($existing_resource_id as $key => $value) {
              $existing_project_resources = ProjectResources::where('project_id', $project_id)->where('user_id', $value)->get();
              $existing_project_resources[0]->project_id = $project_id;
              $existing_project_resources[0]->user_id = $value;
              $existing_project_resources[0]->designation_id = $existing_designation_id[$key];
              $existing_project_resources[0]->hours = $existing_resource_hours[$key];
              $existing_project_resources[0]->save();
            }
          }

        }
        return Redirect::to('/project-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Remove the specified resource assigned for the project from database.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroyProjectResource($project_id, $user_id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $project_resource = ProjectResources::where('project_id', $project_id)->where('user_id', $user_id)->delete();

        return Redirect::to("/edit-project/$project_id");
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Remove the specified project from database.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $project = Project::find($id);
        $project->delete();

        return Redirect::to('/project-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }
}
