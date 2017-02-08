<?php

namespace App\Http\Controllers;

use App\Designation;

use App\Http\Controllers\Controller;

use App\Roles;
use App\User;
use App\UserDetails;

use Illuminate\Http\Request;
use Input;
use Redirect;

use Session;

class AdminController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			$user_id     = Session::get('user')[0]['user_id'];
			$users_info  = User::with('UserDetails')->where('status',1)->orderBy('user_id', 'desc')->get();
			$designation = array('' => 'Designation')+Designation::select('designation.designation_name', 'designation.designation_id')->lists('designation_name', 'designation_id')->toArray();
			$roles       = array('' => 'Select role')+Roles::select('roles.role_name', 'roles.role_id')->lists('role_name', 'role_id')->toArray();
			$details = UserDetails::select('joining_date','user_id')->orderBy('user_id', 'desc')->get();
			
			for($i=0;$i<count($details);$i++)
			{
				$joining_date_timestamp=strtotime($details[$i]->joining_date);
				$details[$i]->joining_date=date('d/m/Y',$joining_date_timestamp);
				
			}
			//echo $details[count($details)-1]->joining_date."----->".$details[count($details)-1]->user_id."<br>";

			return view('admin/add-user-create', compact('users_info', 'designation', 'roles','details'));
		} else {
			return Redirect::to('/');
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function search(Request $request) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			if ($request->ajax()) {
				echo $request->search;
				$user = User::where('first_name', 'LIKE', '%'.$request->search.'%')->orWhere('last_name', 'LIKE', '%'.$request->search.'%')->get();
				if ($user) {
					$user_info = [];
					foreach ($user as $key => $users) {
						$users_info = UserDetails::where('user_id', $users->user_id)->get()->first();
						if ($users->role_id == 1) {
							$users->role_id = "Admin";
						} else {
							$users->role_id = "User";
						}
						$designation = $users_info->designation_id;
						switch ($designation) {
							case "1":
							$users_info->designation_id = "Developer";
							break;
							case "2":
							$users_info->designation_id = "Quality Analyst";
							break;
							case "3":
							$users_info->designation_id = "Project Manager";
							break;
							case "4":
							$users_info->designation_id = "Design team";
							break;
							default:
						}
						$user_row = '<tr>'.
						'<td>'.$users->user_id.'</td>'.
						'<td>'.'<span class="name-capital">'.$users->first_name.'</span>'.' '.
						'<span class="name-capital">'.$users->last_name.'</span>'.'</td>'.
						'<td>'.$users->username.'</td>'.
						'<td>'.$users_info->designation_id.'</td>'.
						'<td>'.$users_info->joining_date.'</td>'.
						'<td>'.$users->role_id.'</td>'.
						'<td>'.'<button type="button" class="btn btn-edit edit" id="edit-user" data-id="'.$users->user_id.'">Edit User</button>'.'</td>'.
						'<td>'.'<button type="button" class="btn btn-delete confirm" id="delete-user" data-id="'.$users->user_id.'" data-toggle="modal" data-target="#confirm-delete">Delete User</button>'.'</td>'.
						'</tr>';
						array_push($user_info, $user_row);
						echo "$user_row";
					}
					return Response($user_info);
				} else {
					return response()->json(['message' => 'Record not found']);
				}
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
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			

			if ($request->ajax()) {
				$email   = Input::get('email');
				$check_email=User::select('username')->where('username',$email)->get();
				if(count($check_email)>0)
				{
					return response()->json([
						'success' =>0
						]);
				}
				else
				{
						$joining_date_timestamp=strtotime(str_replace("/", "-", Input::get('joining_date')));
				$joining_date=date('Y-m-d',$joining_date_timestamp);

				$inserted_id;

				$user             = new User;
				$user->first_name = Input::get('fname');
				$user->last_name  = Input::get('lname');
				$user->username   = Input::get('email');
				$user->password   = \Hash::make(Input::get('password'));
				$user->role_id    = Input::get('role');

				if ($user->save()) {
					$inserted_id                  = $user->user_id;
					$user_details                 = new UserDetails;
					$user_details->user_id        = $inserted_id;
					$user_details->designation_id = Input::get('designation');
					$user_details->qualification  = Input::get('qualification');
					$user_details->address        = Input::get('address');
					$user_details->mobile_no      = Input::get('mobile_no');
					$user_details->alternate_no   = Input::get('alt_no');
					$user_details->joining_date   = $joining_date;
					$user_details->save();
				}
				$user_details->joining_date   = Input::get('joining_date');
				return response()->json([
					'user'        => $user,
					'user_detail' => $user_details,
					'success'	=>1
					]);
				}
			
			}
		} else {
			return Redirect::to('/');
		}
	}

	public function getDetails(Request $request) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			return view('admin/add-details');
		} else {
			return Redirect::to('/');
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			if ($request->ajax()) {
				// var_dump($request);
				$user = User::with('UserDetails')->find($request->header('id'));
				return Response($user);
			}
		} else {
			return Redirect::to('/');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			if ($request->ajax()) {
				$joining_date_timestamp=strtotime(str_replace("/", "-", $request->joining_date));
				$joining_date=date('Y-m-d',$joining_date_timestamp);

				$user             = User::find($id);
				if($user->username==$request->email)
				{
					$success=1;
				}
				else
				{
				 $check_email=User::select('username')->where('username',$request->email)->get();
				 if(count($check_email)>0)
				 	$success=0;
				 else
				 	$success=1;
				}
				if($success==1)
				{
					$user->first_name = $request->fname;
				$user->last_name  = $request->lname;
				$user->username   = $request->email;
				if ($request->password) {
					$user->password = \Hash::make($request->password);
				}
				$user->role_id = $request->role;
				$user->update();

				$user_details                 = UserDetails::find($id);
				$user_details->designation_id = $request->designation;
				$user_details->qualification  = $request->qualification;
				$user_details->address        = $request->address;
				$user_details->mobile_no      = $request->mobile_no;
				$user_details->alternate_no   = $request->alt_no;
				$user_details->joining_date   = $joining_date;
				$user_details->update();
				$user_details->joining_date   =$request->joining_date;
				return response()->json([
					'user'        => $user,
					'user_detail' => $user_details,
					'success'	=>$success
					]);
				}
				else
				{
					return response()->json([
					'success'	=>$success
					]);
				}
				
			}
		} else {
			return Redirect::to('/');
		}
	}

	public function destroy(Request $request, $id) {
		$session = Session::get('user')[0]['role_id'];
		if ($session == 1) {
			if ($request->ajax()) {

				$user = User::find($id);
				$user->status=0;
				$user->save();
//				$user->delete();

				$user_details = UserDetails::find($id);
				//$user_details->delete();

				return response()->json([
					'user'        => $user,
					'user_detail' => $user_details
					]);
			}
		}
	}
}
