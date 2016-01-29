@extends('master')

@section('content')

<div class="wrap-table">
<div class="style">
	<a href="/create-user" title="Create User">Create User</a>
</div>

<table>
	<thead>
		<tr>
		  <th>#</th>
			<th>User Id</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>
			<th>Designation</th>
			<th>Date of Joining</th>
			<th>Mobile Number</th>
			<th>Role</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
    <?php $count = 1; ?>
    @foreach ($users_info as $user)
		<tr>
		  <td>{{$count}}</td>
			<td>{{$user->user_id}}</td>
			<td>{{$user->first_name}}</td>
			<td>{{$user->last_name}}</td>
			<td>{{$user->username}}</td>
			<td>
			  @foreach ($designation as $key => $value)
				  @if ($user->UserDetails['designation_id'] == $key)
				    {{$value}}
				  @endif
			  @endforeach
			</td>
			<td>{{$user->UserDetails['joining_date']}}</td>
			<td>{{$user->UserDetails['mobile_no']}}</td>
			<td>
        @foreach ($roles as $key => $value)
				  @if ($user->role_id == $key)
				    {{$value}}
				  @endif
			  @endforeach
			</td>
			<td><a href="edit-user/{{$user->user_id}}" title="Edit" class="edit">Edit</a></td>
			<td>
			{!! Form::open(array('url' => array('delete-user', $user->user_id))) !!}

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
