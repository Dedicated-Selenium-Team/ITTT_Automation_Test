@extends('master')

@section('content')

<a href="/time-management">Back</a>

<h1>Create Timesheet</h1>

{!! Form::open(array('url' => array('store-timesheet', $user_id, $timesheet_date), 'id' => 'create-timesheet')) !!}

<div class="form-group">
  {!! Form::label('project', 'Project') !!}
  {!! Form::select('project', $projects, null, array('multiple'=>'multiple')) !!}
  <span class="add-project">Add</span>
</div>

<div class="form-group">
  {!! Form::label('activity', 'Activity') !!}
  {!! Form::select('activity', $activities, null, array('multiple'=>'multiple')) !!}
  <span class="add-activity">Add</span>
</div>

<table class="project-data">
	<thead>
		<tr>
			<th>Project Name</th>
			<th>Hours Utilised</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

<table class="activity-data">
	<thead>
		<tr>
			<th>Activity Name</th>
			<th>Hours Utilised</th>
		</tr>
	</thead>
	<tbody>

	</tbody>
</table>

{!! Form::submit('Save') !!}

{!! Form::close() !!}

@stop
