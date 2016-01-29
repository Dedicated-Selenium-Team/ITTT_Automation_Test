<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Input;
use Redirect;
use DB;
use Response;

class Login extends Controller
{
  /**
   * Display a Login form.
   *
   * @return Response
   */
  public function index()
  {
    $session = Session::get('user')[0]['role_id'];
    if($session == 1)
    {
      return Redirect::to('user-management');
    }
    elseif($session == 2)
    {
      return Redirect::to('user-view');
    }
    else
    {
      $error = "";
      return view('login/index', compact('error'));
    }
  }

  /**
   * Authenticate User.
   *
   * @return Response
   */
  public function login(Request $request)
  {
  	$this->validate($request, [
      'email'         => 'required|email',
      'password'      => 'required',
    ]);

  	$userdata = array(
		  'username' => Input::get('email'),
		  'password' => Input::get('password')
		);

    Auth::attempt($userdata);
    $user_info = Auth::user();

  	if (!empty($user_info))
    {
      $data = Array(
        'email'   => $user_info['username'],
        'role_id' => $user_info['role_id'],
        'user_id' => $user_info['user_id']
      );

      Session::push('user', $data);

      if($user_info['role_id'] == 1)
      {
        return Redirect::to('user-management');
      }
      elseif($user_info['role_id'] == 2)
      {
        return Redirect::to('user-view');
      }
    }
    else
    {
      $error = "Username or Password does not match";
      return view('login/index', compact('error'));
    }
  }

  /**
   * Logout
   *
   * @return Response
   */
  public function logout()
  {
    //Session::forget('user');
    Session::flush();
    return Redirect::to('/');
  }
}
