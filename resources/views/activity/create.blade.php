@extends('master')

@section('content')

<div class="wrap-content cf">

<a href="/activity-management" title="Back" class="back">Back</a>

<h1>Create Activity</h1>

{!! Form::open(array('url' => 'store-activity', 'id' => 'create-activity')) !!}

<div class="form-group cf">
  {!! Form::label('activity-name', 'Activity Name') !!}
  {!! Form::text('activity-name', Input::old('activity-name'), array('class' => 'form-control')) !!}
  {!! $errors->first('activity-name', '<div>:message</div>') !!}
</div>

{!! Form::submit('Add') !!}

{!! Form::close() !!}

</div>

@stop
