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


Route::get('/', 'Login@index');

Route::post('/login', 'Login@login');

Route::get('/logout', 'Login@logout');

Route::get('/user-management', 'UserController@adminView');

Route::get('/client-management', 'ClientController@index');

Route::get('/activity-management', 'ActivityController@index');

Route::get('/project-management', 'ProjectController@index');

Route::get('/time-management', 'TimeTrackerController@index');

Route::get('/reports', 'ReportController@index');

Route::get('/my-projects/{id}', 'MyProjectsController@index');

Route::get('/user-view', 'UserController@userView');

Route::get('/create-user', 'UserController@create');

Route::get('/create-client', 'ClientController@create');

Route::get('/create-activity', 'ActivityController@create');

Route::get('/create-project', 'ProjectController@create');

Route::get('/create-timesheet/{date}', 'TimeTrackerController@create');

Route::post('/store-user', 'UserController@store');

Route::post('/store-client', 'ClientController@store');

Route::post('/store-activity', 'ActivityController@store');

Route::post('/store-project', 'ProjectController@store');

Route::post('/store-timesheet/{id}/{date}', 'TimeTrackerController@store');

Route::get('/edit-user/{id}', 'UserController@edit');

Route::get('/edit-client/{id}', 'ClientController@edit');

Route::get('/edit-activity/{id}', 'ActivityController@edit');

Route::get('/edit-project/{id}', 'ProjectController@edit');

Route::get('/delete-project-resource/{project_id}/{user_id}', 'ProjectController@destroyProjectResource');

Route::get('/edit-timesheet/{id}/{date}', 'TimeTrackerController@edit');

Route::get('/remove-existing-project-timesheet/{user_id}/{project_id}/{saved_date}', 'TimeTrackerController@removeProject');

Route::get('/remove-existing-activity-timesheet/{user_id}/{activity_id}/{saved_date}', 'TimeTrackerController@removeActivity');

Route::resource('/allocate-hours/{project_id}/{user_id}/{project_hours}', 'MyProjectsController@allocateHours');

Route::post('createPreviousTimesheet', 'TimeTrackerController@createPreviousTimesheet');

Route::resource('/update-user/{id}', 'UserController@update');

Route::resource('/update-client/{id}', 'ClientController@update');

Route::resource('/update-activity/{id}', 'ActivityController@update');

Route::resource('/update-project/{id}', 'ProjectController@update');

Route::resource('/update-timesheet/{id}/{date}', 'TimeTrackerController@update');

Route::resource('/delete-user/{id}', 'UserController@destroy');

Route::resource('/delete-client/{id}', 'ClientController@destroy');

Route::resource('/delete-activity/{id}', 'ActivityController@destroy');

Route::resource('/delete-project/{id}', 'ProjectController@destroy');

Route::resource('/submit-timesheet/{id}/{date}', 'TimeTrackerController@submit');

Route::resource('/delete-timesheet/{id}/{date}', 'TimeTrackerController@destroy');
