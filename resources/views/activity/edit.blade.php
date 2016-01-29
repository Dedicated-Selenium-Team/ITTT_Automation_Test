@extends('master')

@section('content')

<div class="wrap-content cf">

<a href="/activity-management" title="Back" class="back">Back</a>

<h1>Edit Activity</h1>

{!! Form::open(array('url' => array('update-activity', $activity->activity_id))) !!}

<div class="form-group cf">
  {!! Form::label('activity-name', 'Activity Name') !!}
  {!! Form::text('activity-name', $activity->activity_name, array('class' => 'form-control')) !!}
  {!! $errors->first('activity-name', '<div>:message</div>') !!}
</div>

{!! Form::submit('Update') !!}

{!! Form::close() !!}

</div>

@stop
