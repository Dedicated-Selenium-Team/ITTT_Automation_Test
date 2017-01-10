@extends('master')
<title>ITTT | My Projects</title>

@section('content')

<div class="my-projects-main-wrapper">
	@foreach ($project_info as $project)
	<?php $total_project_hours = 0;
	if(!empty($user_projects_hours[$project->project_id])) { ?>
		@foreach ($user_projects_hours[$project->project_id] as $project_hour)
		<?php
		$total_project_hours += $project_hour;
		?>
		@endforeach
		<?php } ?>
		@foreach ($project->ProjectResources as $resource)
		@if ($user_info[0]->user_id == $resource->user_id)
		<div class="my-projects-wrapper">
			<div class="project-info">
				<p class="project-name">{{$project->project_name}}</p>
				<p>Allocated hours: <span class="bold">{{$resource->hours}}</span></p>
				<p>utilized hours: <span class="bold">{{$total_project_hours}}</span></p>
			</div>
			{!! Form::open(array('url' => array('allocate-hours', $project->project_id, $user_info[0]->user_id, $resource->hours), 'class' => 'allocate-hours')) !!}
			<div class="form-group">
				{!! Form::label('resource', 'Select Resource') !!}
				{!! Form::select('', $users, null, array('multiple'=>'multiple', 'class'=>'resource')) !!}
				{!! Form::hidden('resource-id', '', array('id' => 'client-id')) !!}
				<span class="add-resource">Add</span>
				<div class="resource-names-main-wrapper cf">
				</div>
			</div>
			<input type="hidden" value="{{$project->project_id}}">
			<div class="save-project">
				{!! Form::submit('Save') !!}
			</div>
			{!! Form::close() !!}
		</div>
		@endif
		@endforeach
		@endforeach
	</div>

	@stop
