@extends('master')

@section('content')

<div class="wrap-content cf">

<a href="/client-management" title="Back" class="back">Back</a>

<h1>Edit Client</h1>

{!! Form::open(array('url' => array('update-client', $client->client_id))) !!}

<div class="form-group cf">
  {!! Form::label('client-name', 'Client Name') !!}
  {!! Form::text('client-name', $client->client_name, array('class' => 'form-control')) !!}
  {!! $errors->first('client-name', '<div>:message</div>') !!}
</div>

{!! Form::submit('Update') !!}

{!! Form::close() !!}

</div>

@stop
