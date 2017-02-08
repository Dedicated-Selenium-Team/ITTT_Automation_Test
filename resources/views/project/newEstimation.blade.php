@extends('master')

@section('content')
<div class="toggleExample">

</div>

<div class="phase">
	<a href="#FIXME" class="btnAdd">Add</a>
	<div class="lightbox">
		<div class="lightbox-clild">
			{!! Form::open(['url' => '#']) !!}
			<div class="phase-list" id="phase-list">
				<div class="form-group cf">
					{!!Form::label('phase', 'Select Phase');!!}
					{!!Form::Select('phase',$phases);!!}
					{!! Form::hidden('phase-id', '', array('class' => 'phase-id')) !!}
				</div>
				<div class="form-group cf">
					{!!Form::label('designation', 'Select Designation');!!}
					<select>
  					<option value="volvo">Volvo</option>
						<option value="saab">Saab</option>
						<option value="opel">Opel</option>
						<option value="audi">Audi</option>
					</select>
				</div>
				<div class="form-group cf">
					{{-- 		{!!Form::submit('	Click Me',array('id' => 'designation-id'));!!} --}}
					<a href="#FIXME" class="designation-btn add-designation">Click Here</a>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group">
		<input type="button" id="add" value="Add" width="100px"/>
		<table id="tableId">
			<th>
				<p class="demo"></p>
			</th>
			{{-- <tr>
				<td>PM</td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<input class="req_gather" name="req_gather_pm" type="text">
				</td>
				<td>
					<span class="pm_work_per_day">0%</span>
				</td>
				<td></td>
				<td></td>
				<td>
					<span class="hrs_cal_req_gather_pm">0</span>
					<span>Hrs</span>
				</td>
				<td></td>
			</tr>
			<tr>
				<td>
					Senior/Tech Lead
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<input class="req_gather_tech_lead req_gather">
				</td>
				<td>
					<span class="tech_lead_work_per_day">0%</span>
				</td>
				<td></td>
				<td></td>
				<td>
					<span class="hrs_cal_req_gather_tech_lead">0</span>
					<span>Hrs</span>
				</td>
				<td></td>
			</tr> --}}

		</table>
		<div class="addTable"></div>

		<div class="home">
			<div class="estimation">
  <div class="table-content cf">
    <table class="estimation-report">
      <thead>
        <tr>
          <th>Timeline:</th>
          <th>Timeline - days</th>
          <th>Timeline - months (calc)</th>
          <th>Approx. resources involved</th>
          <th>How much time (hours), per day (timeline), do you expect each resource to spend (on this phase)?</th>
          <th>Approx. utilization of these resources/day (calc)</th>
          <th>Effective resources utilized (calc)</th>
          <th>Effective days (resources utilized * days) (calc)</th>
          <th>hrs (calc)</th>
          <th>Phase/resource notes</th>
        </tr>
      </thead>
      <tbody data-group="p">
        <tr>
          <th data-phase-id="1">
            Requirements Gathering/Conversations
          </th>
          <td>
            {!! Form::text('require_gather',Input::old('require_gather'), array('class' => 'require_gather')) !!}
          </td>
          <td>
            <span class="require_gather_month">0</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('effective_resources')!!} --}}
            <span class="effective_resources">0</span>

          </td>
          <td>
            {{-- {!! Form::text('effective_days_utilezed')!!} --}}
            <span class="effective_days_utilezed">0</span>
            <span>Days</span>
          </td>
          <td>
            {{-- {!! Form::text('hrs_cal')!!} --}}
            <span class="hrs_cal">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {{-- {!! Form::textarea('require_gather_note') !!} --}}
          </td>
        </tr>
        <tr>
          <td>
            PM
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('req_gather_pm', Input::old('req_gather_pm'), array('class' => 'require_gather')) !!}
          </td>
          <td>
            <span class="pm_work_per_day">0%</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('hrs_cal_req_gather_pm')!!} -->
            <span class="hrs_cal_req_gather_pm">0</span>
            <span>Hrs</span>
          </td>
          <td>

          </td>
        </tr>
        <tr>
          <td>
            Senior/Tech Lead
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('req_gather_tech_lead', Input::old('req_gather_tech_lead'), array('class' => 'require_gather')) !!}
          </td>
          <td>
            <span class="tech_lead_work_per_day">0%</span>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('hrs_cal_req_gather_tech_lead')!!} -->
            <span class="hrs_cal_req_gather_tech_lead">0</span>
            <span>Hrs</span>
          </td>
          <td>

          </td>
        </tr>
        {{-- Design/UX  Part--}}
        <tr>
          <th  data-phase-id="2">
            Design/UX
          </th>
          <td>
            {!! Form::text('design_timeline_days',Input::old('design_timeline_days'), array('class' => 'design')) !!}
          </td>
          <td>
            <span class="design_timeline_months">0</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('design_effective_resources')!!} -->
            <span class="design_effective_resources">0</span>
          </td>
          <td>
            <!-- {!! Form::text('design_effective_days_utilezed')!!} -->
            <span class="design_effective_days_utilezed">0</span>
            <span>Days</span>
          </td>
          <td>
            <!-- {!! Form::text('design_hrs_cal')!!} -->
            <span class="design_hrs_cal">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {{-- {!! Form::textarea('design_note') !!} --}}
          </td>
        </tr>
        <tr>
          <td>
            PM
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('designer_pm_expected_time',Input::old('designer_pm_expected_time'), array('class' => 'design')) !!}
          </td>
          <td>
            <span class="design_pm_work_per_day">0%</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('hrs_cal_design_pm')!!} -->
            <span class="hrs_cal_design_pm">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            (+Designer) Designer 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('designer_d1_expected_time',Input::old('designer_d1_expected_time'), array('class' => 'design')) !!}
          </td>
          <td>
            <span class="design_d1_work_per_day">0%</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('hrs_cal_design_d1')!!} -->
            <span class="hrs_cal_design_d1">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            (+Designer) Designer 2
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('designer_d2_expected_time',Input::old('designer_d2_expected_time'), array('class' => 'design')) !!}
          </td>
          <td>
            <span class="design_d2_work_per_day">0%</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('hrs_cal_design_d2')!!} -->
            <span class="hrs_cal_design_d2">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{-- Development Back-End ONLY --}}
        <tr>
          <th  data-phase-id="3">
            Development Back-End ONLY
          </th>
          <td>
            {!! Form::text('backend_dev_timeline_days',Input::old('backend_dev_timeline_days'), array('class' => 'backend_development')) !!}
          </td>
          <td>
            <span class="backend_dev_timeline_months">0</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <span class="backend_dev_effective_resources">0</span>
          </td>
          <td>
            <span class="backend_dev_effective_days_utilezed">0</span>
            <span>Days</span>
          </td>
          <td>
            <span class="backend_dev_hrs_cal">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {{-- {!! Form::textarea('backend_dev_note') !!} --}}
          </td>
        </tr>
        <tr>
          <td>
            PM
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('backend_dev_pm_expected_time',Input::old('backend_dev_pm_expected_time'), array('class' => 'backend_development')) !!}
          </td>
          <td>
            <span class="be_pm_work_per_day">0%</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('hrs_cal_backend_dev_pm')!!} -->
            <span class="hrs_cal_backend_dev_pm">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            back-end Dev 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('backend_dev_d1_expected_time',Input::old('backend_dev_d1_expected_time'), array('class' => 'backend_development')) !!}
          </td>
          <td>
            <span class="be_dev_d1_work_per_day">0%</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('hrs_cal_backend_dev_d1')!!} -->
            <span class="hrs_cal_backend_dev_d1">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            back-end Dev 2
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('backend_dev_d2_expected_time',Input::old('backend_dev_d2_expected_time'), array('class' => 'backend_development')) !!}
          </td>
          <td>
            <span class="be_dev_d2_work_per_day">0%</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <!-- {!! Form::text('hrs_cal_backend_dev_d2')!!} -->
            <span class="hrs_cal_backend_dev_d2">0</span>
            <span>Hrs</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{-- Development Front-End ONLY --}}
        <tr>
          <th  data-phase-id="4">
            Development Front-End ONLY
          </th>
          <td>
            {!! Form::text('frontend_dev_timeline_days',Input::old('frontend_dev_timeline_days'), array('class' => 'front_development')) !!}
          </td>
          <td>
            {{-- {!! Form::text('frontend_ev_timeline_months')!!} --}}
            <span class="frontend_dev_timeline_months">0</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('frontend_dev_effective_resources')!!} --}}
            <span class="frontend_dev_effective_resources">0</span>
          </td>
          <td>
            {{-- {!! Form::text('frontend_dev_effective_days_utilezed')!!} --}}
            <span class="frontend_dev_effective_days_utilezed">0</span>
          </td>
          <td>
            {{-- {!! Form::text('frontend_dev_hrs_cal')!!} --}}
            <span class="frontend_dev_hrs_cal">0</span>
          </td>
          <td>
            {{-- {!! Form::textarea('frontend_dev_note') !!} --}}
          </td>
        </tr>
        <tr>
          <td>
            PM
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('frontend_dev_pm_expected_time')!!} --}}
            {!! Form::text('frontend_dev_pm_expected_time',Input::old('frontend_dev_pm_expected_time'), array('class' => 'front_development')) !!}
          </td>
          <td>
            13%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_frontend_dev_pm')!!} --}}
            <span class="hrs_cal_frontend_dev_pm">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            Front-end Dev 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
             {!! Form::text('frontend_dev_d1_expected_time',Input::old('frontend_dev_d1_expected_time'), array('class' => 'front_development')) !!}
          </td>
          <td>
            100%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <span class="hrs_cal_frontend_dev_d1">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            Front-end Dev 2
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {!! Form::text('frontend_dev_d2_expected_time',Input::old('frontend_dev_d2_expected_time'), array('class' => 'front_development')) !!}
          </td>
          <td>
            0%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            <span class="spanhrs_cal_frontend_dev_d2">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{-- Testing/QA Only --}}
        <tr>
          <th  data-phase-id="5">
            Testing/QA ONLY
          </th>
          <td>
            {{-- {!! Form::text('testing_timeline_days')!!} --}}
            {!! Form::text('testing_timeline_days',Input::old('testing_timeline_days'), array('class' => 'testing')) !!}
          </td>
          <td>
            {{-- {!! Form::text('testing_timeline_months')!!} --}}
            <span class="testing_timeline_months">0</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('testing_effective_resources')!!} --}}
            <span class="testing_effective_resources">0</span>
          </td>
          <td>
            {{-- {!! Form::text('testing_effective_days_utilezed')!!} --}}
            <span class="testing_effective_days_utilezed">0</span>
          </td>
          <td>
            {{-- {!! Form::text('testing_hrs_cal')!!} --}}
            <span class="testing_hrs_cal">0</span>
          </td>
          <td>
            {{-- {!! Form::textarea('testing_note') !!} --}}
          </td>
        </tr>
        <tr>
          <td>
            PM
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('testing_pm_expected_time')!!} --}}
            {!! Form::text('testing_pm_expected_time',Input::old('testing_pm_expected_time'), array('class' => 'testing')) !!}
          </td>
          <td>
            13%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_testing_pm')!!} --}}
            <span class="hrs_cal_testing_pm">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            Tester 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('testing_d1_expected_time')!!} --}}
            {!! Form::text('testing_d1_expected_time',Input::old('testing_d1_expected_time'), array('class' => 'testing')) !!}
          </td>
          <td>
            100%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_testing_d1')!!} --}}
            <span class="hrs_cal_testing_d1">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            Tester 2
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('testing_d2_expected_time')!!} --}}
            {!! Form::text('testing_d2_expected_time',Input::old('testing_d2_expected_time'), array('class' => 'testing')) !!}
          </td>
          <td>
            0%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_testing_d2')!!} --}}
            <span class="hrs_cal_testing_d2">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{-- Final Developement/testing(Fixing)--}}
        <tr>
          <th  data-phase-id="6">
            Final Development/Testing (Fixing)
          </th>
          <td>
            {{-- {!! Form::text('fin_dev_timeline_days')!!} --}}
            {!! Form::text('fin_dev_timeline_days',Input::old('fin_dev_timeline_days'), array('class' => 'final_development')) !!}
          </td>
          <td>
            {{-- {!! Form::text('fin_dev_timeline_months')!!} --}}
            <span class="fin_dev_timeline_months">0</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('fin_dev_effective_resources')!!} --}}
            <span class="fin_dev_effective_resources">0</span>
          </td>
          <td>
            {{-- {!! Form::text('fin_dev_effective_days_utilezed')!!} --}}
            <span class="fin_dev_effective_days_utilezed">0</span>
          </td>
          <td>
            {{-- {!! Form::text('fin_dev_hrs_cal')!!} --}}
            <span class="fin_dev_hrs_cal">0</span>
          </td>
          <td>
            {{-- {!! Form::textarea('fin_dev_note') !!} --}}
          </td>
        </tr>
        <tr>
          <td>
            PM
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('fin_dev_pm_expected_time')!!} --}}
              {!! Form::text('fin_dev_pm_expected_time',Input::old('fin_dev_pm_expected_time'), array('class' => 'final_development')) !!}
          </td>
          <td>
            13%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_fin_dev_pm')!!} --}}
            <span class="hrs_cal_fin_dev_pm">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            Back-end Dev 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('fin_dev_be_expected_time')!!} --}}
            {!! Form::text('fin_dev_be_expected_time',Input::old('fin_dev_be_expected_time'), array('class' => 'final_development')) !!}
          </td>
          <td>
            0%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_fin_dev_be_d1')!!} --}}
            <span class="hrs_cal_fin_dev_be_d1">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{--  --}}
        <tr>
          <td>
            Front-end Dev 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('fin_dev_fe_expected_time')!!} --}}
             {!! Form::text('fin_dev_fe_expected_time',Input::old('fin_dev_fe_expected_time'), array('class' => 'final_development')) !!}

          </td>
          <td>
            0%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_fin_dev_fe_d1')!!} --}}
            <span class="hrs_cal_fin_dev_fe_d1">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{--  --}}
        <tr>
          <td>
            Tester 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('fin_dev_tester_expected_time')!!} --}}
              {!! Form::text('fin_dev_tester_expected_time',Input::old('fin_dev_tester_expected_time'), array('class' => 'final_development')) !!}
          </td>
          <td>
            100%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_fin_dev_tester')!!} --}}
            <span class="hrs_cal_fin_dev_tester">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{-- Deployement/Go Live --}}
        <tr>
          <th  data-phase-id="7">
            Deployment/Go-Live
          </th>
          <td>
            {{-- {!! Form::text('deployement_timeline_days')!!} --}}
               {!! Form::text('deployement_timeline_days',Input::old('deployement_timeline_days'), array('class' => 'deployment')) !!}
          </td>
          <td>
            {{-- {!! Form::text('deployement_timeline_months')!!} --}}
            <span class="deployement_timeline_months">0</span>
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('deployement_effective_resources')!!} --}}
            <span class="deployement_effective_resources">0</span>
          </td>
          <td>
            {{-- {!! Form::text('deployement_effective_days_utilezed')!!} --}}
            <span class="deployement_effective_days_utilezed">0</span>
          </td>
          <td>
            {{-- {!! Form::text('deployement_hrs_cal')!!} --}}
            <span class="deployement_hrs_cal">0</span>
          </td>
          <td>
            {{-- {!! Form::textarea('deployement_note') !!} --}}
          </td>
        </tr>
        <tr>
          <td>
            PM
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('deployement_pm_expected_time')!!} --}}
            {!! Form::text('deployement_pm_expected_time',Input::old('deployement_pm_expected_time'), array('class' => 'deployment')) !!}
          </td>
          <td>
            13%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_deployement_pm')!!} --}}
            <span class="hrs_cal_deployement_pm">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <td>
            Back-end Dev 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('deployement_be_expected_time')!!} --}}
            {!! Form::text('deployement_be_expected_time',Input::old('deployement_be_expected_time'), array('class' => 'deployment')) !!}
          </td>
          <td>
            0%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_deployement_be_d1')!!} --}}
            <span class="hrs_cal_deployement_be_d1">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{--  --}}
        <tr>
          <td>
            Front-end Dev 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('deployement_fe_expected_time')!!} --}}
            {!! Form::text('deployement_fe_expected_time',Input::old('deployement_fe_expected_time'), array('class' => 'deployment')) !!}
          </td>
          <td>
            0%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_deployement_fe_d1')!!} --}}
            <span class="hrs_cal_deployement_fe_d1">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        {{--  --}}
        <tr>
          <td>
            Tester 1
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('deployement_tester_expected_time')!!} --}}
            {!! Form::text('deployement_tester_expected_time',Input::old('deployement_tester_expected_time'), array('class' => 'deployment')) !!}
          </td>
          <td>
            100%
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            {{-- {!! Form::text('hrs_cal_deployement_tester')!!} --}}
            <span class="hrs_cal_deployement_tester">0</span>
          </td>
          <td>
            {!! Form::label('')!!}
          </td>
        </tr>
        <tr>
          <th>
            Timeline to LIVE (calc):
          </th>
          <td>
            {!! Form::text('t2live_timeline_days')!!}
          </td>
          <td>
            {!! Form::text('t2live_timeline_months')!!}
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            TOTALS >>
          </td>
          <td>
            {!! Form::text('t2live_effective_days_utilezed')!!}
          </td>
          <td>
            {!! Form::text('t2live_hrs_cal')!!}
          </td>
          <td>
            {{-- {!! Form::textarea('t2live_note') !!} --}}
          </td>
        </tr>
        <tr>
          <td>
            Backwards working:
          </td>
          <td>
            {!! Form::text('backword_timeline_days')!!}
          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>

          </td>
          <td>
            effective resources over project until LIVE - NOT incl. of warranty period:
          </td>
          <td>
            {!! Form::text('backword_effective_days_utilezed')!!}
          </td>
          <td>

          </td>
          <td>

          </td>
        </tr>
        <tr>
          <th>
            Working Hrs:
          </th>
          <td>
            {!! Form::label('total effective days utilezed','$')!!}
          </td>
          <td>
            {!! Form::label('total effective Hours utilezed','$')!!}
          </td>
        </tr>
        <tr>
          <td>
            Working Days per Month:
          </td>
          <td>
            {!! Form::label('total effective days utilezed',' ')!!}
          </td>
          <td>
            {!! Form::label('total effective Month utilezed','$')!!}
          </td>
        </tr>
        <tr>
          <td>
            Working Hrs per Month:
          </td>
          <td>
            {!! Form::label('total effective days utilezed',' ')!!}
          </td>
          <td>
            {!! Form::label('total effective Month utilezed','$')!!}
          </td>
        </tr>
      </tbody>
    </table>

    {!! Form::submit('Submit',array('class' => 'submit-btn')) !!}
    {!! Form::close() !!}
  </div>
</div>
		</div>

	</div>
	{!! Form::close() !!}
	@stop

