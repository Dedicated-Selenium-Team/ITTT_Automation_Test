@extends('master')
@section('content')
<div class="row">
	<div class="admin">
		<nav>
			<ul class="admin-ul">
				<li class="admin-list">
					<a href="/admin" class="admin-menu"><i class="fa fa-user" aria-hidden="true"></i> USER</a>
				</li>
				<li class="admin-list">
					<a href="/admin/add-details" class="admin-menu"><i class="fa fa-cogs" aria-hidden="true"></i> SETTING </a>
				</li>
			</ul>
		</nav>
		{!! Form::open(array('url' => array(''))) !!}
		<div class="admin-info add-details-info">
	{{-- 				<div class="row">
					<div class="col-lg-4 col-sm-4">
						{!! Form::label('month', 'Select Month: ') !!}
					</div>
					<div class="col-lg-4 col-sm-4">
						{!! Form::select('role') !!}
						{!! Form::hidden('role-id','',array('id' => 'role-id'))!!}
					</div>
				</div> --}}
				<div class="row">
					<div class="col-lg-3 col-sm-3">
						{!! Form::label('workingDays', 'Working Hours per Day : ') !!}
					</div>
					<div class="col-lg-3 col-sm-3">
						{!! Form::text('workingDays','',array('class' => 'form-control','placeholder' => '00')) !!}
					</div>
				</div>
				<div class="row">
					<div class="col-lg-3 col-sm-3">
						{!! Form::label('workingMonths', 'Working Hours per Months :') !!}
					</div>
					<div class="col-lg-3 col-sm-3">
						{!! Form::text('workingMonths','', array('class' => 'form-control','placeholder' => '00')) !!}
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6 col-sm-6">
							<button type="button" class="btn btn-success" id="submit-add-details" data-id="" >Submit</button>
					</div>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
	@stop