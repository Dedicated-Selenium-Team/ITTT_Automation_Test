<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Auth;

use Illuminate\Http\Request;
use App\User;
use Input;
use Redirect;
use Session;
use DB;
use Response;
use Carbon;

class Login extends Controller
{
/**
* Display a Login form.
*
* @return Response
*/
public function index($error = null)
{
  $date = Carbon\Carbon::now()->format('Y-m-d');
  $session = Session::get('user')[0]['role_id'];
  if($session == 1)
  {
    return redirect()->route('day-time', ['date' => $date]);
  }
  elseif ($session == 2) {
    return redirect()->route('day-time', ['date' => $date]);
  }
  else
  {    
   return view('login/index', compact('error'));
 }
}


   /**
    * Authenticate User.
    *
    * @return Response
    */
   public function login(Request $request) {

    if ($request->isMethod('POST')) {
     Input::merge(array_map('trim', Input::all()));


     $this->validate($request, [
      'email'    => 'required|email',
      'password' => 'required',
      ]);


     $userdata = array(
       'username' => trim(Input::get('email')),
       'password' => Input::get('password')
       );

     if (Auth::attempt($userdata)) {
      $remember = Input::get('remember');

               // Auth::attempt($userdata);
      $user_info = Auth::user();


      if (!empty($user_info)) {
       $data = Array(
        'email'   => $user_info['username'],
        'role_id' => $user_info['role_id'],
        'user_id' => $user_info['user_id'],
        'first_name'=>$user_info['first_name'],
        'last_name'=>$user_info['last_name'],
        );

       Session::push('user', $data);
       if (!empty($remember)) {
        Auth::login($user_info->id, true);
        if ($user_info['role_id'] == 1) {
         return Redirect::to('user-management');
       } 
       elseif ($user_info['role_id'] == 2) {
         return Redirect::to('user-view');
       }
     }
     else {
       return Redirect::to('/');
     }
                   // return Redirect::to('/'); }
   } 
   else {  }
 }
else {

  $user_name =  User::select('username')->where('username', $userdata['username'])->get();
  if(count($user_name)>0){
    $error = "Username or Password does not match";
  } 
  else {
    $error = "You are unauthorized user";
  }
  return view('login/index', compact('error'));
}

}

else {
 return Redirect::to('/');
}
}

   /**
    * Logout
    *
    * @return Response
    */
   public function logout() {
       //Session::forget('user');
     Session::flush();
     return Redirect::to('/');
   }

   public function gmaillogin(Request $request) {
       //Session::forget('user');
     $success=0;

     $email=$request->email;
     $user=new User;
     $checkemail=$user->where('username',$email)->get();

     if(count($checkemail)>0)
     {
       $success=1;

       $data = Array(
        'email'   => $email,
        'role_id' => $checkemail[0]->role_id,
        'user_id' => $checkemail[0]->user_id,
        'first_name'=>$checkemail[0]->first_name,
        'last_name'=>$checkemail[0]->last_name,
        );

       Session::push('user', $data);
     }
     
     return response()->json([
       "success"=>$success
       ]);
   }
 }

