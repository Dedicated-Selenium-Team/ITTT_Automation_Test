@extends('master')

@section('content')

<div class="my-projects-main-wrapper">
	@foreach ($project_info as $project)
	  <?php $total_project_hours = 0; ?>
	  @foreach ($user_projects_hours[$project->project_id] as $project_hour)
	  <?php
	    $total_project_hours += $project_hour;
	  ?>
	  @endforeach
	  @foreach ($project->ProjectResources as $resource)
	    @if ($user_info[0]->user_id == $resource->user_id)
	      <div class="my-projects-wrapper">
		      <div>
		        <p class="project-name">{{$project->project_name}}</p>
		        <p class="project-name">Allocated hours: {{$resource->hours}}</p>
		        <p class="project-name">utilized hours: {{$total_project_hours}}</p>
		      </div>
		      {!! Form::open(array('url' => array('allocate-hours', $project->project_id, $user_info[0]->user_id, $resource->hours), 'id' => 'allocate-hours')) !!}
			      <div class="form-group">
						  {!! Form::label('resource', 'Select Resource') !!}
						  {!! Form::select('', $users, null, array('multiple'=>'multiple', 'class'=>'resource')) !!}
						  {!! Form::hidden('resource-id', '', array('id' => 'client-id')) !!}
						  <span class="add-resource">Add</span>
			  			<div class="resource-names-main-wrapper">
			  			</div>
						</div>
						<input type="hidden" value="{{$project->project_id}}">
						{!! Form::submit('Save') !!}
					{!! Form::close() !!}
				</div>
	    @endif
	  @endforeach
	@endforeach
</div>

@stop
