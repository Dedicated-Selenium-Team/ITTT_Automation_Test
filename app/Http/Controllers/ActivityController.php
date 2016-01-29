<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Activity;
use Input;
use Redirect;
use DB;
use Response;
use Session;

class ActivityController extends Controller
{
    /**
     * Display a activity list.
     *
     * @return Response
     */
    public function index()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1)
      {
        $activity_info = Activity::get();
        return view('activity/index', compact('activity_info'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Show the form for creating a new activity.
     *
     * @return Response
     */
    public function create()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        return view('activity/create');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Store a newly created activity in database.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        // $this->validate($request, [
        //   'activity-name'         => 'required'
        // ]);

        $activity = new Activity;
        $activity->activity_name = Input::get('activity-name');
        $activity->save();

        return Redirect::to('/activity-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Display the specified activity.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified activity.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $activity = Activity::find($id);
        return view('activity/edit', compact('activity'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Update the specified activity in database.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
          // $this->validate($request, [
        //   'activity-name'         => 'required'
        // ]);

        $activity = Activity::find($id);
        $activity->activity_name = Input::get('activity-name');
        $activity->save();

        return Redirect::to('/activity-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Remove the specified activity from database.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $activity = Activity::find($id);
        $activity->delete();

        return Redirect::to('/activity-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }
}
