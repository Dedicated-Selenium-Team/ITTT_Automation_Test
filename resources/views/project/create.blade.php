@extends('master')

@section('content')

<div class="wrap-content cf">

<a href="/project-management" title="Back" class="back">Back</a>

<h1>Create Project</h1>

{!! Form::open(array('url' => 'store-project', 'id' => 'create-project')) !!}

<div class="form-group cf">
  {!! Form::label('project-name', 'Project Name') !!}
  {!! Form::text('project-name', Input::old('project-name'), array('class' => 'form-control')) !!}
  {!! $errors->first('project-name', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('client', 'Client') !!}
  {!! Form::select('client', $client) !!}
  {!! Form::hidden('client-id', '', array('id' => 'client-id')) !!}
</div>

<div class="form-group cf">
  {!! Form::label('project-manager', 'Project Manager') !!}
  {!! Form::select('project-manager', $project_manager, null, array('multiple'=>'multiple')) !!}
  <span id="add-pm">Add</span>
  <div class="names-main-wrapper"></div>
</div>

<div class="form-group cf">
  {!! Form::label('developer', 'Developers') !!}
  {!! Form::select('developer', $developer, null, array('multiple'=>'multiple')) !!}
  <span id="add-developer">Add</span>
  <div class="names-main-wrapper"></div>
</div>

<div class="form-group cf">
  {!! Form::label('quality-analyst', 'Quality Analyst') !!}
  {!! Form::select('quality-analyst', $quality_analyst, null, array('multiple'=>'multiple')) !!}
  <span id="add-qa">Add</span>
  <div class="names-main-wrapper"></div>
</div>

<div class="form-group cf">
  {!! Form::label('design', 'Design Team') !!}
  {!! Form::select('design', $design_team, null, array('multiple'=>'multiple')) !!}
  <span id="add-design">Add</span>
  <div class="names-main-wrapper"></div>
</div>

<div class="form-group cf">
  {!! Form::label('estimated-time', 'Estimated Time') !!}
  {!! Form::text('estimated-time', Input::old('estimated-time'), array('class' => 'form-control')) !!}
  {!! $errors->first('estimated-time', '<div>:message</div>') !!}
</div>

{!! Form::submit('Add') !!}

{!! Form::close() !!}

</div>

@stop
