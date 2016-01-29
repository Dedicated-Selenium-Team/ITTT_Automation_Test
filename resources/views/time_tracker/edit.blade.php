@extends('master')

@section('content')

<a href="/time-management">Back</a>

<h1>Edit Timesheet</h1>

{!! Form::open(array('url' => array('update-timesheet', $user_id, $saved_date), 'id' => 'edit-timesheet')) !!}

<div class="form-group-wrapper">
	<div class="form-group">
	  {!! Form::label('project', 'Project') !!}
	  {!! Form::select('project', $projects, null, array('multiple' => 'multiple')) !!}
	  <span class="add-project">Add</span>
	</div>

	<div class="form-group">
	  {!! Form::label('activity', 'Activity') !!}
	  {!! Form::select('activity', $activities, null, array('multiple' => 'multiple')) !!}
	  <span class="add-activity">Add</span>
	</div>
</div>

<table class="project-data">
	<thead>
		<tr>
			<th>Project Name</th>
			<th>Hours Utilised</th>
		</tr>
	</thead>
	<tbody class="existing-project-main-wrapper">
		@foreach ($pending_project_timesheet as $timesheet)
		  <tr class="existing-entry">
		  	@foreach ($projects as $key => $value)
		  		@if ($timesheet->project_id == $key)
		  		  <td class="project-name">{{$value}}</td>
		  		  <td class="project-hours"><input type="text" name="existing-project-hours[]" value="{{$timesheet->invested_time}}"><a href="/remove-existing-project-timesheet/{{$timesheet->user_id}}/{{$timesheet->project_id}}/{{$timesheet->saved_date}}" class="remove-existing-project">Remove</a><input type="hidden" name="existing-project-id[]" value="{{$timesheet->project_id}}"></td>
		  	  @endif
		  	@endforeach
		  </tr>
		@endforeach
	</tbody>
</table>

<table class="activity-data">
	<thead>
		<tr>
			<th>Activity Name</th>
			<th>Hours Utilised</th>
		</tr>
	</thead>
	<tbody class="existing-activity-main-wrapper">
		@foreach ($pending_activity_timesheet as $timesheet)
		  <tr class="existing-entry">
		  	@foreach ($activities as $key => $value)
		  		@if ($timesheet->activity_id == $key)
		  		  <td class="activity-name">{{$value}}</td>
		  		  <td class="activity-hours"><input type="text" name="existing-activity-hours[]" value="{{$timesheet->invested_time}}"><a href="/remove-existing-activity-timesheet/{{$timesheet->user_id}}/{{$timesheet->activity_id}}/{{$timesheet->saved_date}}" class="remove-existing-activity">Remove</a><input type="hidden" name="existing-activity-id[]" value="{{$timesheet->activity_id}}"></td>
		  	  @endif
		  	@endforeach
		  </tr>
		@endforeach
	</tbody>
</table>

{!! Form::submit('Update') !!}

{!! Form::close() !!}

@stop
