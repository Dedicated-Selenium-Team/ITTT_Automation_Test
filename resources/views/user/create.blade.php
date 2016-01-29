@extends('master')

@section('content')

<div class="wrap-content cf">

<a href="/user-management" title="Back" class="back">Back</a>

<h1>Create User</h1>

{!! Form::open(array('url' => 'store-user', 'id' => 'create-user')) !!}

<div class="form-group cf">
  {!! Form::label('fname', 'First Name') !!}
  {!! Form::text('fname', Input::old('fname'), array('class' => 'form-control')) !!}
  {!! $errors->first('fname', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('lname', 'Last Name') !!}
  {!! Form::text('lname', Input::old('lname'), array('class' => 'form-control')) !!}
  {!! $errors->first('lname', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('designation', 'Designation') !!}
  {!! Form::select('designation', $designation) !!}
  {!! Form::hidden('designation-id', '', array('id' => 'designation-id')) !!}
</div>

<div class="form-group cf">
  {!! Form::label('qualification', 'Qualification') !!}
  {!! Form::text('qualification', Input::old('qualification'), array('class' => 'form-control')) !!}
  {!! $errors->first('qualification', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('address', 'Address') !!}
  {!! Form::text('address', Input::old('address'), array('class' => 'form-control')) !!}
  {!! $errors->first('address', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('mobile_no', 'Mobile Number') !!}
  {!! Form::text('mobile_no', Input::old('mobile_no'), array('class' => 'form-control')) !!}
  {!! $errors->first('mobile_no', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('alt_no', 'Alternate Number') !!}
  {!! Form::text('alt_no', Input::old('alt_no'), array('class' => 'form-control')) !!}
  {!! $errors->first('alt_no', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('joining_date', 'Date of Joining') !!}
  {!! Form::date('joining_date', \Carbon\Carbon::now()) !!}
  {!! $errors->first('joining_date', '<div>:message</div>') !!}
</div>

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

<div class="form-group cf">
  {!! Form::label('re-password', 'Re-enter Password') !!}
  {!! Form::password('re-password', Input::old('re-password'), array('class' => 'form-control')) !!}
  {!! $errors->first('re-password', '<div>:message</div>') !!}
</div>

<div class="form-group cf">
  {!! Form::label('role', 'Role type') !!}

  {!! Form::select('role', $roles) !!}
  {!! Form::hidden('role-id', '', array('id' => 'role-id')) !!}
</div>

{!! Form::submit('Add') !!}

{!! Form::close() !!}

</div>

@stop
