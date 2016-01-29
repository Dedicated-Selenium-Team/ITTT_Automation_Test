@extends('master')

@section('content')

<div class="wrap-content cf">

<a href="/client-management" title="Back" class="back">Back</a>

<h1>Create Client</h1>

{!! Form::open(array('url' => 'store-client', 'id' => 'create-client')) !!}

<div class="form-group cf">
  {!! Form::label('client-name', 'Client Name') !!}
  {!! Form::text('client-name', Input::old('client-name'), array('class' => 'form-control')) !!}
  {!! $errors->first('client-name', '<div>:message</div>') !!}
</div>

{!! Form::submit('Add') !!}

{!! Form::close() !!}

</div>

@stop
