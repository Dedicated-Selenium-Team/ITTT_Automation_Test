<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\UserDetails;
use App\Roles;
use App\Designation;
use Input;
use Redirect;
use DB;
use Response;
use Session;

class UserController extends Controller
{
    /**
     * Display a Users list.
     *
     * @return Response
     */
    public function adminView()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1)
      {
        $users_info = User::with('UserDetails')->get();
        $designation = Designation::select('designation.designation_name', 'designation.designation_id')->lists('designation_name', 'designation_id');
        $roles = Roles::select('roles.role_name', 'roles.role_id')->lists('role_name', 'role_id');
        return view('user/admin-view', compact('users_info', 'designation', 'roles'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Display a Users list.
     *
     * @return Response
     */
    public function userView()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 2) {
        return view('user/user-view');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $roles = array('' => 'Please Select') + Roles::lists('role_name','role_id')->toArray();
        $designation = array('' => 'Please Select') + Designation::lists('designation_name','designation_id')->toArray();
        return view('user/create', compact('roles', 'designation'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Store a newly created User in database.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $inserted_id;
        // $this->validate($request, [
        //   'fname'         => 'required',
        //   'lname'         => 'required',
        //   'email'         => 'required|email|unique:users',
        //   'designation'   => 'required',
        //   'qualification' => 'required',
        //   'address'       => 'required',
        //   'joining_date'  => 'required',
        //   'mobile_no'     => 'required',
        //   'alt_no'        => 'required',
        //   'password'      => 'required',
        //   're-password'   => 'same:password',
        //   'role_id'       => 'required'
        // ]);

        $user = new User;
        $user->first_name = Input::get('fname');
        $user->last_name  = Input::get('lname');
        $user->username   = Input::get('email');
        $user->password   = \Hash::make(Input::get('password'));
        $user->role_id    = Input::get('role-id');

        if($user->save()) {
          $inserted_id = $user->user_id;
          $user_details = new UserDetails;
          $user_details->user_id        = $inserted_id;
          $user_details->designation_id = Input::get('designation-id');
          $user_details->qualification  = Input::get('qualification');
          $user_details->address        = Input::get('address');
          $user_details->mobile_no      = Input::get('mobile_no');
          $user_details->alternate_no   = Input::get('alt_no');
          $user_details->joining_date   = Input::get('joining_date');
          $user_details->save();
        }

        return Redirect::to('/user-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Display the specified User.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $user = User::with('UserDetails')->find($id);
        $roles = array('' => 'Please Select') + Roles::lists('role_name','role_id')->toArray();
        $designation = array('' => 'Please Select') + Designation::lists('designation_name','designation_id')->toArray();
        return view('user/edit', compact('user', 'roles', 'designation'));
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Update the specified User in database.
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
        //   'fname'         => 'required',
        //   'lname'         => 'required',
        //   'email'         => 'required|email|unique:users',
        //   'designation'   => 'required',
        //   'qualification' => 'required',
        //   'address'       => 'required',
        //   'joining_date'  => 'required',
        //   'mobile_no'     => 'required',
        //   'alt_no'        => 'required',
        //   'password'      => 'required',
        //   're-password'   => 'same:password',
        //   'role_id'       => 'required'
        // ]);

        $user = User::find($id);
        $user->first_name = Input::get('fname');
        $user->last_name  = Input::get('lname');
        $user->username   = Input::get('email');
        $user->password   = \Hash::make(Input::get('password'));
        $user->role_id    = Input::get('role-id');
        $user->save();

        $user_details = UserDetails::find($id);
        $user_details->designation_id = Input::get('designation-id');
        $user_details->qualification  = Input::get('qualification');
        $user_details->address        = Input::get('address');
        $user_details->mobile_no      = Input::get('mobile_no');
        $user_details->alternate_no   = Input::get('alt_no');
        $user_details->joining_date   = Input::get('joining_date');
        $user_details->save();

        return Redirect::to('/user-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }

    /**
     * Remove the specified User from database.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
      $session = Session::get('user')[0]['role_id'];
      if($session == 1) {
        $user = User::find($id);
        $user->delete();

        $user_details = UserDetails::find($id);
        $user_details->delete();

        return Redirect::to('/user-management');
      }
      else
      {
        return 'Access restricted!';
      }
    }
}
