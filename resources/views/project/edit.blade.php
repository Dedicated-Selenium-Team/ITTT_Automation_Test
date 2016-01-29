@extends('master')

@section('content')

<div class="wrap-content cf">

<a href="/project-management" title="Back" class="back">Back</a>

<h1>Edit Project</h1>

{!! Form::open(array('url' => array('update-project', $project->project_id), 'id' => 'edit-project')) !!}

<div class="form-group cf">
  {!! Form::label('project-name', 'Project Name') !!}
  {!! Form::text('project-name', $project->project_name, array('class' => 'form-control')) !!}
  {!! $errors->first('project-name', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('client', 'Client') !!}
  {!! Form::select('client', $client) !!}
  {!! Form::hidden('client-id', $project->client_id, array('id' => 'client-id')) !!}
</div>

<div class="form-group cf">
  {!! Form::label('project-manager', 'Project Manager') !!}
  {!! Form::select('project-manager', $project_manager, null, array('multiple'=>'multiple')) !!}
  <span id="add-pm">Add</span>
  <div class="existing-names-main-wrapper">
    @foreach ($project->ProjectResources as $resource)
      @if($resource->designation_id == 3)
        <div class="existing-pm-name-wrapper">
          @foreach ($project_manager as $key => $value)
            @if($key == $resource->user_id)
              <span class="pm-name">{{$value}}</span>
            @endif
          @endforeach
          <input type="text" name="existing-resource-hours[]" value={{$resource->hours}}>
          <a href="/delete-project-resource/{{$resource->project_id}}/{{$resource->user_id}}">Remove</a>
          <input type="hidden" class="user-id" name="existing-resource-id[]" value={{$resource->user_id}}>
          <input type="hidden" name="existing-designation-id[]" value="3">
        </div>
      @endif
    @endforeach
  </div>
  <div class="names-main-wrapper"></div>
</div>

<div class="form-group cf">
  {!! Form::label('developer', 'Developers') !!}
  {!! Form::select('developer', $developer, null, array('multiple'=>'multiple')) !!}
  <span id="add-developer">Add</span>
  <div class="existing-names-main-wrapper">
    @foreach ($project->ProjectResources as $resource)
      @if($resource->designation_id == 1)
        <div class="existing-dev-name-wrapper">
          @foreach ($developer as $key => $value)
            @if($key == $resource->user_id)
              <span class="dev-name">{{$value}}</span>
            @endif
          @endforeach
          <input type="text" name="existing-resource-hours[]" value={{$resource->hours}}>
          <a href="/delete-project-resource/{{$resource->project_id}}/{{$resource->user_id}}">Remove</a>
          <input type="hidden" class="user-id" name="existing-resource-id[]" value={{$resource->user_id}}>
          <input type="hidden" name="existing-designation-id[]" value="1">
        </div>
      @endif
    @endforeach
  </div>
  <div class="names-main-wrapper"></div>
</div>

<div class="form-group cf">
  {!! Form::label('quality-analyst', 'Quality Analyst') !!}
  {!! Form::select('quality-analyst', $quality_analyst, null, array('multiple'=>'multiple')) !!}
  <span id="add-qa">Add</span>
  <div class="existing-names-main-wrapper">
    @foreach ($project->ProjectResources as $resource)
      @if($resource->designation_id == 2)
        <div class="existing-qa-name-wrapper">
          @foreach ($quality_analyst as $key => $value)
            @if($key == $resource->user_id)
              <span class="qa-name">{{$value}}</span>
            @endif
          @endforeach
          <input type="text" name="existing-resource-hours[]" value={{$resource->hours}}>
          <a href="/delete-project-resource/{{$resource->project_id}}/{{$resource->user_id}}">Remove</a>
          <input type="hidden" class="user-id" name="existing-resource-id[]" value={{$resource->user_id}}>
          <input type="hidden" name="existing-designation-id[]" value="2">
        </div>
      @endif
    @endforeach
  </div>
  <div class="names-main-wrapper"></div>
</div>

<div class="form-group cf">
  {!! Form::label('design', 'Design Team') !!}
  {!! Form::select('design', $design_team, null, array('multiple'=>'multiple')) !!}
  <span id="add-design">Add</span>
  <div class="existing-names-main-wrapper">
    @foreach ($project->ProjectResources as $resource)
      @if($resource->designation_id == 4)
        <div class="existing-design-name-wrapper">
          @foreach ($design_team as $key => $value)
            @if($key == $resource->user_id)
              <span class="design-name">{{$value}}</span>
            @endif
          @endforeach
          <input type="text" name="existing-resource-hours[]" value={{$resource->hours}}>
          <a href="/delete-project-resource/{{$resource->project_id}}/{{$resource->user_id}}">Remove</a>
          <input type="hidden" class="user-id" name="existing-resource-id[]" value={{$resource->user_id}}>
          <input type="hidden" name="existing-designation-id[]" value="4">
        </div>
      @endif
    @endforeach
  </div>
  <div class="names-main-wrapper"></div>
</div>

<div class="form-group cf">
  {!! Form::label('estimated-time', 'Estimated Time') !!}
  {!! Form::text('estimated-time', $project->estimated_time, array('class' => 'form-control')) !!}
  {!! $errors->first('estimated-time', '<div>:message</div>') !!}
</div>

{!! Form::submit('Update') !!}

{!! Form::close() !!}

</div>

@stop
