@extends('master')

@section('content')
<?php
  if(count($created_project_timesheet) > count($created_activity_timesheet)) {
  	$created_timesheet = $created_project_timesheet;
  } else {
  	$created_timesheet = $created_activity_timesheet;
  }

  if(!isset($created_timesheet[0])) { ?>
    <div>
		  <a href="/create-timesheet/<?php echo date('Y-m-d'); ?>">Create New Timesheet</a>
	  </div>
<?php }
  if(count($pending_project_timesheets) > count($pending_activity_timesheets)) {
  	$timesheets = $pending_project_timesheets;
  } else {
  	$timesheets = $pending_activity_timesheets;
  }
?>

<div>
	<span id="create-prev-timesheet-wrapper">Create Previous Timesheet</span>
	<div class="hide-select-date-wrapper">
		<span>Select date: </span>
		<input class="selected-date" type="date" />
		<span id="create-prev-timesheet-btn">create</span>
		<input type="hidden" class="csrf-token" value="{{ csrf_token() }}" />
		<span id="timesheet-created-message"></span>
	</div>
</div>

<table>
  <thead>
    <tr>
	    <th>#</th>
	    <th>Pending Timesheets</th>
	    <th>Edit</th>
	    <th>Submit</th>
	    <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    @if ($timesheets)
      <?php $count = 1; ?>
	    @foreach ($timesheets as $timesheet)
		    <tr>
		     <td>{{$count}}</td>
		     <td>{{$timesheet->saved_date}}</td>
		     <td><a href="/edit-timesheet/{{$timesheet->user_id}}/{{$timesheet->saved_date}}">Edit</a></td>
		     <td>
				   {!! Form::open(array('url' => array('submit-timesheet', $timesheet->user_id, $timesheet->saved_date))) !!}

			     {!! Form::submit('Submit') !!}

			     {!! Form::close() !!}
		     </td>
		     <td>
				   {!! Form::open(array('url' => array('delete-timesheet', $timesheet->user_id, $timesheet->saved_date))) !!}

			     {!! Form::submit('Delete') !!}

			     {!! Form::close() !!}
		     </td>
		    </tr>
		    <?php $count++; ?>
		  @endforeach
	  @endif
  </tbody>
</table>

@stop
