@extends('master')

@section('content')

<div class="wrap-table">

<div class="style">
	<a href="/create-client" title="Create Client">Create Client</a>
</div>

<table>
	<thead>
		<tr>
			<th>#</th>
			<th>Client Id</th>
			<th>Client Name</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
	  <?php $count = 1; ?>
    @foreach ($client_info as $client)
		<tr>
		  <td>{{$count}}</td>
			<td>{{$client->client_id}}</td>
			<td>{{$client->client_name}}</td>
			<td><a href="edit-client/{{$client->client_id}}" title="Edit" class="edit">Edit</a></td>
			<td>
			{!! Form::open(array('url' => array('delete-client', $client->client_id))) !!}

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
