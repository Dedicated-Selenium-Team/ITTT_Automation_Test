@extends('master')

@section('content')

<div class="wrap-table">

<div class="style">
	<a href="/create-activity" title="Create Activity">Create Activity</a>
</div>

<table>
	<thead>
		<tr>
		  <th>#</th>
			<th>Activity Id</th>
			<th>Activity Name</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
	  <?php $count = 1; ?>
    @foreach ($activity_info as $activity)
		<tr>
		  <td>{{$count}}</td>
			<td>{{$activity->activity_id}}</td>
			<td>{{$activity->activity_name}}</td>
			<td><a href="edit-activity/{{$activity->activity_id}}" title="Edit" class="edit">Edit</a></td>
			<td>
			{!! Form::open(array('url' => array('delete-activity', $activity->activity_id))) !!}

			{!! Form::submit('Delete') !!}

			{!! Form::close() !!}
			</td>
		</tr>
		<?php $count += 1; ?>
		@endforeach

	</tbody>
</table>

</div>

@stop
