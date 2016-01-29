@extends('master')

@section('content')

<div class="wrap-table">

<div class="style">
	<a href="/create-project" title="Create Project">Create Project</a>
</div>

<table>
	<thead>
		<tr>
		  <th>#</th>
			<th>Project Id</th>
			<th>Project Name</th>
			<th>Client Name</th>
			<th>Project Managers</th>
			<th>Developers</th>
			<th>Quality Analysts</th>
			<th>Design</th>
			<th>Estimated time</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
	<?php $count = 1; ?>
	@foreach ($project_info as $project)
		<tr>
		  <td>{{$count}}</td>
			<td>{{$project->project_id}}</td>
			<td>{{$project->project_name}}</td>
			<td>
				@foreach ($clients as $key => $value)
				  @if ($project->client_id == $key)
				    {{$value}}
				  @endif
			  @endforeach
			</td>
			<td>
				@foreach ($project->ProjectResources as $resource)
				  @if ($resource->designation_id == 3)
				    @foreach ($users as $key => $value)
							@if ($key == $resource->user_id)
								{{$value}}
							@endif
			      @endforeach
			    @endif
			  @endforeach
			</td>
			<td>
				@foreach ($project->ProjectResources as $resource)
				  @if ($resource->designation_id == 1)
				    @foreach ($users as $key => $value)
							@if ($key == $resource->user_id)
								{{$value}}
							@endif
			      @endforeach
			    @endif
			  @endforeach
			</td>
			<td>
				@foreach ($project->ProjectResources as $resource)
				  @if ($resource->designation_id == 2)
				    @foreach ($users as $key => $value)
							@if ($key == $resource->user_id)
								{{$value}}
							@endif
			      @endforeach
			    @endif
			  @endforeach
			</td>
			<td>
				@foreach ($project->ProjectResources as $resource)
				  @if ($resource->designation_id == 4)
				    @foreach ($users as $key => $value)
							@if ($key == $resource->user_id)
								{{$value}}
							@endif
			      @endforeach
			    @endif
			  @endforeach
			</td>
			<td>{{$project->estimated_time}}</td>
			<td><a href="edit-project/{{$project->project_id}}" title="Edit" class="edit">Edit</a></td>
			<td>
			{!! Form::open(array('url' => array('delete-project', $project->project_id))) !!}

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

