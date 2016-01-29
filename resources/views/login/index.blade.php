@extends('master')

@section('content')

<div class="wrap-content">

<h1>Login</h1>

{{ $error }}

{!! Form::open(array('url' => 'login')) !!}

<div class="form-group cf">
  {!! Form::label('email', 'Email') !!}
  {!! Form::text('email', Input::old('name'), array('class' => 'form-control')) !!}
  {!! $errors->first('email', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('password', 'Password') !!}
  {!! Form::password('password', Input::old('password'), array('class' => 'form-control')) !!}
  {!! $errors->first('password', '<div>:message</div>') !!}
</div>

{!! Form::submit('Login') !!}

{!! Form::close() !!}
</div>
@stop
