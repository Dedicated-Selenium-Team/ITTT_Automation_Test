<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/************ Login page *************/
Route::get('/', 'Login@index');
Route::post('/login',[    
	'uses' => 'Login@login'
	]);
Route::get('/login',[    
	'uses' => 'Login@index'
	]);
Route::post('/gmaillogin','Login@gmaillogin');
Route::get('/logout', 'Login@logout');
Route::post('/change','Login@change_password');
Route::get('test','EstimattionController@test');
/*Route::post('test','EstimattionController@test');
Route::get('test',function(){
	return view('test');
});*/

/************ Projects tab *************/
Route::get('/store_project/estimate/{id}', 'EstimattionController@index');
Route::get('/store_project/planning/{id}', 'PlanningController@index');
Route::get('/store_project', ['as' => 'store-project', 'uses' => 'ProjectController@backProject']);
Route::post('/store_project','ProjectController@storeProject');
Route::post('/estimate/store/{id}', ['as' => 'submitEstimate', 'uses' => 'EstimattionController@store']);
Route::post('/planning/store/{id}', ['as' => 'submitPlan', 'uses' => 'PlanningController@store']);
Route::post('/planning/{id}', ['as'       => 'submitPlanning', 'uses'       => 'PlanningController@store']);
Route::get('/edit-project', 'ProjectController@editProject');

Route::post('/delete-project/{id}', 'ProjectController@deleteProject');
Route::post('/archive-project/{id}', 'ProjectController@archiveProject');
Route::post('/test','EstimattionController@test');
/************ Admin tab *************/
Route::get('/admin', 'AdminController@index');
Route::get('/admin-edit-user', 'AdminController@edit');
Route::post('/admin-delete-user/{id}', 'AdminController@destroy');
Route::get('/search', 'AdminController@search');
Route::get('/admin/add-details', 'AdminController@getDetails');
Route::post('/store-admin-user/{id?}', 'AdminController@store');
Route::put('/store-admin-user/{id?}', 'AdminController@update');

/************ My Projects tab *************/
Route::get('/my-projects/{id}', ['as' => 'projects', 'uses' => 'ProjectController@getProject']);
Route::get('/myself', 'MyselfProjectController@index');
Route::post('/myself/project-details/{name?}/{id?}', 'MyselfProjectController@show');
Route::get('/addself/project-details/{name?}/{id?}/{hrs?}', 'MyselfProjectController@create');
Route::post('/store-self-project/{id?}', 'MyselfProjectController@store');
Route::post('/change_project_status', 'ProjectController@changeStatus');
Route::get('edit_project_info', 'ProjectController@updateProject');
Route::post('/project_info', 'ProjectController@storeProject');

/************ Project Designation tab *************/
Route::get('/project-designation/{id?}', 'ProjectDesignationController@index');
Route::get('/project-values/{name}/{id?}', 'ProjectDesignationController@create');
Route::post('/project-designation/getdesig', 'ProjectDesignationController@getDesignation');
Route::post('/project-designation/getallnumbers/{project_id}', 'ProjectDesignationController@getallhrs');

/************ Timesheet tab *************/
Route::get('/time-management/{date}', ['as' => 'day-time', 'uses' => 'TimeTrackerController@index']);
Route::get('/time-management/week/{date}', 'TimeTrackerController@week');
Route::get('/edit-day-project', 'TimeTrackerController@editProject');
Route::post('/store-time', 'TimeTrackerController@storeTime');
Route::put('/store-time/{id}/{project_id}', 'TimeTrackerController@updateTime');
Route::post('/delete-day-project/{id}', 'TimeTrackerController@deleteTime');
Route::post('/time-management/getmyself_project_designation/{project_id}','TimeTrackerController@getDesignation');

/**
 * Admin can see Users timesheet routes
 */
Route::get('/time-management/{date}/{id}/{project_id?}', ['as' => 'day-time', 'uses' => 'TimeTrackerController@getUserTimesheet']);

Route::get('/time-management/week/{date}/{id}/{project_id?}','TimeTrackerController@getUserWeekTimesheet');

?>
