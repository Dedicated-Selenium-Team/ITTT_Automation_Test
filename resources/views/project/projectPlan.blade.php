@extends('master')
<title>ITTT | Planning</title>

@section('content')

<div class="bread-crumb">
  <div>
    <a href="/store_project">Projects</a>
    <?php 
    $prev_page = $_SERVER['HTTP_REFERER'];
    if(strpos($prev_page, 'project-designation') !== false){
      ?>
      <a href="{{ URL::previous() }}">Project Designation</a>
      <a class="current-page">planning</a>
    </span>
    <?php } else { ?>
      <a class="current-page">planning</a>
    </span>
    <?php } ?>
  </div>
</div>

{{-- This will check the User session and if admin then edit the planning and if not admin then only view Starts here--}}
        
        {!! Form::open(array('route' => ['submitPlan', 'id' => $unique_id])) !!}
<?php
$role_id = Session::get('user')[0]['role_id'];
if ($role_id == 2) {?>
  <div class="user">
   <?php }?>
   {{-- This will check the User session and if admin then edit the planning and if not admin then only view Ends here--}}
   {{-- Project palning starts here --}}
   <div class="numericValidation">
    <div class="estimation-form">
      {{-- project phase starts here --}}
      <div class="project-phase">
        <div class="phase-heading container-heading cf">
         <!--  <div class="back">
            <a href="{{ URL::previous() }}" title="Back">Back</a>
          </div> -->
          <div class="page-title">
            <h2>Planning</h2>
          </div>
          <div class="proj-data">
            <h2>client name: <span class="camle-case">{{$client_name}} </span></h2>
            <h2>project name: <span class="camle-case">{{$pname}} </span></h2>
          </div>
        </div>
        <div class="timeline-heading container-heading">
          <h2 class="ballpark-estimate">ballpark estimate: based on dates</h2>
        </div>
        <div class="phase-data">
          <div class="proj-date">
            <div class="proj-date-snipet">
              {!! Form::label('project-start-date', 'Project Start Date:') !!}
              {!! Form::text('project-start-date', \Carbon\Carbon::now()->format('d/m/Y'),array('class' => 'startDate phaseCalculation form-control datepicker','readonly')) !!}
            </div>
            <div class="proj-date-snipet">
              {!! Form::label('phase-I-end-date', 'Phase 1 End Date:') !!}
              {!! Form::text('phase-I-end-date','',['class' => 'p1Date phaseCalculation form-control datepicker','placeholder'=>'dd/mm/yyyy','readonly']) !!}
            </div>
            <div class="proj-date-snipet">
              {!! Form::label('phase-II-end-date', 'Phase 2 End Date:') !!}
              {!! Form::text('phase-II-end-date','',['class' => 'p2Date phaseCalculation form-control datepicker','placeholder'=>'dd/mm/yyyy','readonly']) !!}
            </div>
          <!-- <div class="proj-date-snipet">
            {!! Form::label('resources', 'Required Resource Number: ')!!}
            {!! Form::text('resources','',['class' => 'resources calculated phaseCalculation form-control'])!!}
          </div> -->
          <div class="proj-date-snipet numericValidation">
            {!! Form::label('Warrenty-days', 'Warranty days:') !!}
            {!! Form::text('Warrenty-days','0',['class' => 'warranty-days phaseCalculation form-control']) !!}
            <p class="note">Warranty days should not exceed more than 100 days.</p>
          </div>
          <div class="proj-date-snipet">
            {!! Form::label('Warrenty-period-end', 'Warranty End Date:') !!}
            {!! Form::text('Warrenty-period-end','',['class' => 'warrantyDate phaseCalculation form-control','placeholder'=>'dd/mm/yyyy','disabled']) !!}
            {!! Form::hidden('Warrenty-period-end','0') !!}
          </div>
          <div class="proj-date-snipet numericValidation">
            {!! Form::label('Warrenty-period-holiday', 'Holiday:') !!}
            {!! Form::text('Warrenty-period-holiday','0',['class' => ' holiday phaseCalculation form-control']) !!}
            <p class="note">This field will affect the warranty date with the effective number of holidays. It should not exceed more than 15 days.</p>
          </div>
        </div>
      </div>
      <div class="pro-date-calulation">
        <table class="pro-date-calulation-table tableData">
          <thead>
            <tr class="table-heading-font head-row">
              <th>{!! Form::label('p1-go-live', 'Timeline till go-live Phase 1 (days)')!!}</th>
              <th>{!! Form::label('timelineDays', 'Timeline overall (days)')!!}</th>
              <th>{!! Form::label('timelineMonths', 'Timeline months equiv')!!}</th>
              <th>{!! Form::label('timelineHours', 'Timeline hours equiv')!!}</th>
              <th>{!! Form::label('timelineTotDays', 'days based on total resources')!!}</th>
              <th> {!! Form::label('timelineTotHours', 'hours based on total resources')!!}</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{!! Form::text('p1-go-live',' ',array('class' => 'input-read', 'disabled'))!!}</td>
              <td>{!! Form::text('timelineDays',' ',array('class' => 'input-read', 'disabled'))!!}</td>
              <td>{!! Form::text('timelineMonths',' ',array('class' => 'input-read', 'disabled'))!!}</td>
              <td>{!! Form::text('timelineHours',' ',array('class' => 'input-read', 'disabled'))!!}</td>
              <td>{!! Form::text('timelineTotDays',' ',array('class' => 'input-read', 'disabled'))!!}</td>
              <td>{!! Form::text('timelineTotHours',' ',array('class' => 'input-read', 'disabled'))!!}</td>
            </tr>
          </tbody>
        </table>
        <div class="proj-date-snipet resource-field numericValidation">
          {!! Form::label('resources', 'How many resources you want to "play with"?')!!}
          <div class="res">
            {!! Form::text('resources','1',['class' => 'resources calculated phaseCalculation form-control'])!!}
            <p class="note">Number of resources should not exceed more than 15.</p>
          </div>
        </div>
      </div>
    </div>
    {{-- project phase ends here --}}


    {{-- project timeline starts here --}}
    <div class="project-timeline">
      <div class="timeline-heading container-heading">
        <h2 class="ballpark-estimate">ballpark estimate: resource utilization</h2>
      </div>
      <div class="timeline-data">
        <div class="phase">
          <div class="form-group cf">
            <div class="home">
              <div class="estimation">
                <div class="table-content cf">
                  <div class="table-wrapper">
                    <table id="newplan" class="estimation-report tableData th-border">
                      <thead>
                        <tr>
                         <th>Timeline:</th>
                         <th title="Number Of Days For Particular Phase">Timeline - days</th>
                         <th title="Timeline Days * Total Working Days Per Month">Timeline - months (calc)</th>
                         <th class="display">Approx. resources involved</th>
                         <th title="Hours Per Day Assigned By Particular Designated Person For Phase">Hours/Day (Max 13 hours)</th>
                         <th title="Hours Per Day / Total Working Hours For Day">Approx. utilization of these resources/day (calc)</th>
                         <th title="Sum Of All Hours-Per-Day For Particular Phase / Total Working Hours For Day">Effective resources utilized (calc)</th>
                         <th title="Effective Resources Utilized * Timeline Days">Effective days (resources utilized * days) (calc)</th>
                         <th title="Total Hours For Particular Phase">hrs (calc)</th>
                         <th class="display">Phase/resource notes</th>
                       </tr>
                     </thead>
<tbody data-group="p">
           <tr class="light-orange">
            <th data-phase-id="1">Requirements Gathering/Conversations
             <input type="hidden" name="phase[Requirements Gathering/Conversations][phase_id]" value="1">
           </th>
           <td><input type="text" value="" class="require_gather timelineDays" name="phase[Requirements Gathering/Conversations][spent_days]"></td>
           <td><span class="require_gather_month timelineMonths"></span></td>
           <td></td>
           <td></td>
           <td></td>
           <td><span class="require_gather_effective_resources eResources"></span></td>
           <td><span class="require_gather_effective_days_utilezed eDays"></span></td>
           <td><span class="require_gather_hrs_cal phaseHourCal"></span></td>
           <td></td>
         </tr>
         <tr>
          <td>PM
           <input type="hidden" value="" name="phase[Requirements Gathering/Conversations][designations][0][PM][row_id]">
           <input type="hidden" value="1" name="phase[Requirements Gathering/Conversations][designations][0][PM][d_id]">
         </td>
         <td></td>
         <td></td>
         <td></td>
         <td><input type="text" class="require_gather hrsLimit pm-hrs" value="" name="phase[Requirements Gathering/Conversations][designations][0][PM][per_day_hours]"></td>
         <td><span class="pm_work_per_day"></span></td>
         <td></td>
         <td></td>
         <td><span class="pm-calc-hrs"></span></td>
         <td></td>
       </tr>
       <tr>
        <td>Tech Lead
         <input type="hidden" value="" name="phase[Requirements Gathering/Conversations][designations][1][Tech Lead][row_id]">
         <input type="hidden" value="6" name="phase[Requirements Gathering/Conversations][designations][1][Tech Lead][d_id]">
       </td>
       <td></td>
       <td></td>
       <td></td>
       <td><input type="text" class="require_gather hrsLimit tech lead-hrs" value="" name="phase[Requirements Gathering/Conversations][designations][1][Tech Lead][per_day_hours]"></td>
       <td><span class="tech lead_work_per_day"></span></td>
       <td></td>
       <td></td>
       <td><span class="tech lead-calc-hrs"></span></td>
       <td></td>
     </tr>
     <tr class="light-orange">
      <th data-phase-id="2">Design/UX
       <input type="hidden" name="phase[Design/UX][phase_id]" value="2">
     </th>
     <td><input type="text" value="" class="design timelineDays" name="phase[Design/UX][spent_days]"></td>
     <td><span class="design_month timelineMonths"></span></td>
     <td></td>
     <td></td>
     <td></td>
     <td><span class="design_effective_resources eResources"></span></td>
     <td><span class="design_effective_days_utilezed eDays"></span></td>
     <td><span class="design_hrs_cal phaseHourCal"></span></td>
     <td></td>
   </tr>
   <tr>
    <td>PM
     <input type="hidden" value="" name="phase[Design/UX][designations][0][PM][row_id]">
     <input type="hidden" value="1" name="phase[Design/UX][designations][0][PM][d_id]">
   </td>
   <td></td>
   <td></td>
   <td></td>
   <td><input type="text" class="design hrsLimit pm-hrs" value="" name="phase[Design/UX][designations][0][PM][per_day_hours]"></td>
   <td><span class="pm_work_per_day"></span></td>
   <td></td>
   <td></td>
   <td><span class="pm-calc-hrs"></span></td>
   <td></td>
 </tr>
<tr>
    <td>Designer
     <input type="hidden" value="" name="phase[Design/UX][designations][1][Designer][row_id]">
     <input type="hidden" value="2" name="phase[Design/UX][designations][1][Designer][d_id]">
   </td>
   <td></td>
   <td></td>
   <td></td>
   <td><input type="text" class="design hrsLimit designer-hrs" value="" name="phase[Design/UX][designations][1][Designer][per_day_hours]"></td>
   <td><span class="designer_work_per_day">0%</span></td>
   <td></td>
   <td></td>
   <td><span class="designer-calc-hrs">0.00</span></td>
   <td></td>
 </tr>
<tr>
  <td>Designer
   <input type="hidden" value="" name="phase[Design/UX][designations][2][Designer][row_id]">
   <input type="hidden" value="2" name="phase[Design/UX][designations][2][Designer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="design hrsLimit designer-hrs" value="" name="phase[Design/UX][designations][2][Designer][per_day_hours]"></td>
 <td><span class="designer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="designer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr class="light-orange">
  <th data-phase-id="3">Development Back-End ONLY
   <input type="hidden" name="phase[Development Back-End ONLY][phase_id]" value="3">
 </th>
 <td><input type="text" value="" class="backend_development timelineDays" name="phase[Development Back-End ONLY][spent_days]"></td>
 <td><span class="backend_development_month timelineMonths"></span></td>
 <td></td>
 <td></td>
 <td></td>
 <td><span class="backend_development_effective_resources eResources"></span></td>
 <td><span class="backend_development_effective_days_utilezed eDays"></span></td>
 <td><span class="backend_development_hrs_cal phaseHourCal"></span></td>
 <td></td>
</tr>
<tr>
  <td>PM
   <input type="hidden" value="" name="phase[Development Back-End ONLY][designations][0][PM][row_id]">
   <input type="hidden" value="1" name="phase[Development Back-End ONLY][designations][0][PM][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="backend_development hrsLimit pm-hrs" value="" name="phase[Development Back-End ONLY][designations][0][PM][per_day_hours]"></td>
 <td><span class="pm_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="pm-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>BE_Developer
   <input type="hidden" value="" name="phase[Development Back-End ONLY][designations][1][BE_Developer][row_id]">
   <input type="hidden" value="4" name="phase[Development Back-End ONLY][designations][1][BE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="backend_development hrsLimit be_developer-hrs" value="" name="phase[Development Back-End ONLY][designations][1][BE_Developer][per_day_hours]"></td>
 <td><span class="be_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="be_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>BE_Developer
   <input type="hidden" value="" name="phase[Development Back-End ONLY][designations][2][BE_Developer][row_id]">
   <input type="hidden" value="4" name="phase[Development Back-End ONLY][designations][2][BE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="backend_development hrsLimit be_developer-hrs" value="" name="phase[Development Back-End ONLY][designations][2][BE_Developer][per_day_hours]"></td>
 <td><span class="be_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="be_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr class="light-orange">
  <th data-phase-id="4">Development Front-End ONLY
   <input type="hidden" name="phase[Development Front-End ONLY][phase_id]" value="4">
 </th>
 <td><input type="text" value="" class="frontend_development timelineDays" name="phase[Development Front-End ONLY][spent_days]"></td>
 <td><span class="frontend_development_month timelineMonths"></span></td>
 <td></td>
 <td></td>
 <td></td>
 <td><span class="frontend_development_effective_resources eResources"></span></td>
 <td><span class="frontend_development_effective_days_utilezed eDays"></span></td>
 <td><span class="frontend_development_hrs_cal phaseHourCal"></span></td>
 <td></td>
</tr>
<tr>
  <td>PM
   <input type="hidden" value="" name="phase[Development Front-End ONLY][designations][0][PM][row_id]">
   <input type="hidden" value="1" name="phase[Development Front-End ONLY][designations][0][PM][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="frontend_development hrsLimit pm-hrs" value="" name="phase[Development Front-End ONLY][designations][0][PM][per_day_hours]"></td>
 <td><span class="pm_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="pm-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>FE_Developer
   <input type="hidden" value="" name="phase[Development Front-End ONLY][designations][1][FE_Developer][row_id]">
   <input type="hidden" value="3" name="phase[Development Front-End ONLY][designations][1][FE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="frontend_development hrsLimit fe_developer-hrs" value="" name="phase[Development Front-End ONLY][designations][1][FE_Developer][per_day_hours]"></td>
 <td><span class="fe_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="fe_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>FE_Developer
   <input type="hidden" value="" name="phase[Development Front-End ONLY][designations][2][FE_Developer][row_id]">
   <input type="hidden" value="3" name="phase[Development Front-End ONLY][designations][2][FE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="frontend_development hrsLimit fe_developer-hrs" value="" name="phase[Development Front-End ONLY][designations][2][FE_Developer][per_day_hours]"></td>
 <td><span class="fe_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="fe_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr class="light-orange">
  <th data-phase-id="5">Testing/QA ONLY
   <input type="hidden" name="phase[Testing/QA ONLY][phase_id]" value="5">
 </th>
 <td><input type="text" value="" class="testing timelineDays" name="phase[Testing/QA ONLY][spent_days]"></td>
 <td><span class="testing_month timelineMonths"></span></td>
 <td></td>
 <td></td>
 <td></td>
 <td><span class="testing_effective_resources eResources"></span></td>
 <td><span class="testing_effective_days_utilezed eDays"></span></td>
 <td><span class="testing_hrs_cal phaseHourCal"></span></td>
 <td></td>
</tr>
<tr>
  <td>PM
   <input type="hidden" value="" name="phase[Testing/QA ONLY][designations][0][PM][row_id]">
   <input type="hidden" value="1" name="phase[Testing/QA ONLY][designations][0][PM][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="testing hrsLimit pm-hrs" value="" name="phase[Testing/QA ONLY][designations][0][PM][per_day_hours]"></td>
 <td><span class="pm_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="pm-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>Tester
   <input type="hidden" value="" name="phase[Testing/QA ONLY][designations][1][Tester][row_id]">
   <input type="hidden" value="5" name="phase[Testing/QA ONLY][designations][1][Tester][d_id]]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="testing hrsLimit tester-hrs" value="" name="phase[Testing/QA ONLY][designations][1][Tester][per_day_hours]"></td>
 <td><span class="tester_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="tester-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>Tester
   <input type="hidden" value="" name="phase[Testing/QA ONLY][designations][2][Tester][row_id]">
   <input type="hidden" value="5" name="phase[Testing/QA ONLY][designations][2][Tester][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="testing hrsLimit tester-hrs" value="" name="phase[Testing/QA ONLY][designations][2][Tester][per_day_hours]"></td>
 <td><span class="tester_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="tester-calc-hrs"></span></td>
 <td></td>
</tr>
<tr class="light-orange">
  <th data-phase-id="6">Final Development/Testing (Fixing)
   <input type="hidden" name="phase[Final Development/Testing (Fixing)][phase_id]" value="6">
 </th>
 <td><input type="text" value="" class="final_development timelineDays" name="phase[Final Development/Testing (Fixing)][spent_days]"></td>
 <td><span class="final_development_month timelineMonths"></span></td>
 <td></td>
 <td></td>
 <td></td>
 <td><span class="final_development_effective_resources eResources"></span></td>
 <td><span class="final_development_effective_days_utilezed eDays"></span></td>
 <td><span class="final_development_hrs_cal phaseHourCal"></span></td>
 <td></td>
</tr>
<tr>
  <td>PM
   <input type="hidden" value="" name="phase[Final Development/Testing (Fixing)][designations][0][PM][row_id]">
   <input type="hidden" value="1" name="phase[Final Development/Testing (Fixing)][designations][0][PM][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="final_development hrsLimit pm-hrs" value="" name="phase[Final Development/Testing (Fixing)][designations][0][PM][per_day_hours]"></td>
 <td><span class="pm_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="pm-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>FE_Developer
   <input type="hidden" value="" name="phase[Final Development/Testing (Fixing)][designations][1][FE_Developer][row_id]">
   <input type="hidden" value="3" name="phase[Final Development/Testing (Fixing)][designations][1][FE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="final_development hrsLimit fe_developer-hrs" value="" name="phase[Final Development/Testing (Fixing)][designations][1][FE_Developer][per_day_hours]"></td>
 <td><span class="fe_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="fe_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>BE_Developer
   <input type="hidden" value="" name="phase[Final Development/Testing (Fixing)][designations][2][BE_Developer][row_id]">
   <input type="hidden" value="4" name="phase[Final Development/Testing (Fixing)][designations][2][BE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="final_development hrsLimit be_developer-hrs" value="" name="phase[Final Development/Testing (Fixing)][designations][2][BE_Developer][per_day_hours]"></td>
 <td><span class="be_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="be_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>Tester
   <input type="hidden" value="" name="phase[Final Development/Testing (Fixing)][designations][3][Tester][row_id]">
   <input type="hidden" value="5" name="phase[Final Development/Testing (Fixing)][designations][3][Tester][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="final_development hrsLimit tester-hrs" value="" name="phase[Final Development/Testing (Fixing)][designations][3][Tester][per_day_hours]"></td>
 <td><span class="tester_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="tester-calc-hrs"></span></td>
 <td></td>
</tr>
<tr class="light-orange">
  <th data-phase-id="7">Deployment/Go-Live
   <input type="hidden" name="phase[Deployment/Go-Live][phase_id]" value="7">
 </th>
 <td><input type="text" value="" class="deployment timelineDays" name="phase[Deployment/Go-Live][spent_days]"></td>
 <td><span class="deployment_month timelineMonths"></span></td>
 <td></td>
 <td></td>
 <td></td>
 <td><span class="deployment_effective_resources eResources"></span></td>
 <td><span class="deployment_effective_days_utilezed eDays"></span></td>
 <td><span class="deployment_hrs_cal phaseHourCal"></span></td>
 <td></td>
</tr>
<tr>
  <td>PM
   <input type="hidden" value="" name="phase[Deployment/Go-Live][designations][0][PM][row_id]">
   <input type="hidden" value="1" name="phase[Deployment/Go-Live][designations][0][PM][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="deployment hrsLimit pm-hrs" value="" name="phase[Deployment/Go-Live][designations][0][PM][per_day_hours]"></td>
 <td><span class="pm_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="pm-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>FE_Developer
   <input type="hidden" value="" name="phase[Deployment/Go-Live][designations][1][FE_Developer][row_id]">
   <input type="hidden" value="3" name="phase[Deployment/Go-Live][designations][1][FE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="deployment hrsLimit fe_developer-hrs" value="" name="phase[Deployment/Go-Live][designations][1][FE_Developer][per_day_hours]"></td>
 <td><span class="fe_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="fe_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>BE_Developer
   <input type="hidden" value="" name="phase[Deployment/Go-Live][designations][2][BE_Developer][row_id]">
   <input type="hidden" value="4" name="phase[Deployment/Go-Live][designations][2][BE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="deployment hrsLimit be_developer-hrs" value="" name="phase[Deployment/Go-Live][designations][2][BE_Developer][per_day_hours]"></td>
 <td><span class="be_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="be_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>Tester
   <input type="hidden" value="" name="phase[Deployment/Go-Live][designations][3][Tester][row_id]">
   <input type="hidden" value="5" name="phase[Deployment/Go-Live][designations][3][Tester][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="deployment hrsLimit tester-hrs" value="" name="phase[Deployment/Go-Live][designations][3][Tester][per_day_hours]"></td>
 <td><span class="tester_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="tester-calc-hrs"></span></td>
 <td></td>
</tr>
<tr class="light-green">
  <th>
   Timeline to LIVE (calc):
 </th>
 <td>
   <span class="t2live_timeline_days"></span>
 </td>
 <td>
   <span class="t2live_timeline_months"></span>
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td>
   TOTALS &gt;&gt;
 </td>
 <td>
   <span class="t2live_effective_days_utilezed"></span>
 </td>
 <td>
   <span class="t2live_hrs_cal"></span>
 </td>
 <td></td>
</tr>
<tr class="light-green">
  <td>
   Backwards working:
 </td>
 <td>
   <span class="backword_timeline_days"></span>
 </td>
 <td>
 </td>
 <td>
 </td>
 <td>
 </td>
 <td>
 </td>
 <td class="left-align">
   effective resources over project until LIVE - NOT incl. of warranty period:
 </td>
 <td>
   <span class="backword_effective_days_utilezed"></span>
 </td>
 <td>
 </td>
 <td>
 </td>
</tr>
<tr class="light-orange">
  <th data-phase-id="8">Warranty Period (30 Working Days)
   <input type="hidden" name="phase[Warranty Period (30 Working Days)][phase_id]" value="8">
 </th>
 <td><input type="text" value="" class="warranty_period  wtot triggerWarranty" name="phase[Warranty Period (30 Working Days)][spent_days]"></td>
 <td><span class="warranty_period_month timelineMonths"></span></td>
 <td></td>
 <td></td>
 <td></td>
 <td><span class="warranty_period_effective_resources eResources"></span></td>
 <td><span class="warranty_period_effective_days_utilezed eDays"></span></td>
 <td><span class="warranty_period_hrs_cal"></span></td>
 <td></td>
</tr>
<tr>
  <td>PM
   <input type="hidden" value="" name="phase[Warranty Period (30 Working Days)][designations][0][PM][row_id]">
   <input type="hidden" value="1" name="phase[Warranty Period (30 Working Days)][designations][0][PM][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="warranty_period hrsLimit pm-hrs" value="" name="phase[Warranty Period (30 Working Days)][designations][0][PM][per_day_hours]"></td>
 <td><span class="pm_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="pm-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>FE_Developer
   <input type="hidden" value="" name="phase[Warranty Period (30 Working Days)][designations][1][FE_Developer][row_id]]">
   <input type="hidden" value="3" name="phase[Warranty Period (30 Working Days)][designations][1][FE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="warranty_period hrsLimit fe_developer-hrs" value="" name="phase[Warranty Period (30 Working Days)][designations][1][FE_Developer][per_day_hours]"></td>
 <td><span class="fe_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="fe_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>BE_Developer
   <input type="hidden" value="" name="phase[Warranty Period (30 Working Days)][designations][2][BE_Developer][row_id]">
   <input type="hidden" value="4" name="phase[Warranty Period (30 Working Days)][designations][2][BE_Developer][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="warranty_period hrsLimit be_developer-hrs" value="" name="phase[Warranty Period (30 Working Days)][designations][2][BE_Developer][per_day_hours]"></td>
 <td><span class="be_developer_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="be_developer-calc-hrs"></span></td>
 <td></td>
</tr>
<tr>
  <td>Tester
   <input type="hidden" value="" name="phase[Warranty Period (30 Working Days)][designations][3][Tester][row_id]">
   <input type="hidden" value="5" name="phase[Warranty Period (30 Working Days)][designations][3][Tester][d_id]">
 </td>
 <td></td>
 <td></td>
 <td></td>
 <td><input type="text" class="warranty_period hrsLimit tester-hrs" value="" name="phase[Warranty Period (30 Working Days)][designations][3][Tester][per_day_hours]"></td>
 <td><span class="tester_work_per_day"></span></td>
 <td></td>
 <td></td>
 <td><span class="tester-calc-hrs"></span></td>
 <td></td>
</tr>
<tr class="light-green">
  <th>
   Timeline to Warranty End (calc):
 </th>
 <td>
   <span class="t2live_warranty_timeline_days"></span>
 </td>
 <td>
   <span class="t2live_warranty_timeline_months"></span>
 </td>
 <td>
 </td>
 <td>
 </td>
 <td>
 </td>
 <td>
   TOTALS &gt;&gt;
 </td>
 <td>
                                       <!-- <input name="t2live_effective_days_utilezed" type="text">
                                     -->
                                     <span class="t2live_warranty_effective_days_utilezed"></span>
                                   </td>
                                   <td>
                                     <!-- <input name="t2live_hrs_cal" type="text"> -->
                                     <span class="t2livewarranty_hrs_cal"></span>
                                   </td>
                                   <td>
                                     <!-- <textarea name="t2live_note" cols="50" rows="10"></textarea> -->
                                   </td>
                                 </tr>
                                 <tr class="light-green">
                                  <td>
                                   Backwards working:
                                 </td>
                                 <td>
                                   <!-- <input name="backword_timeline_days" type="text"> -->
                                   <span class="warranty_backword_timeline_days"></span>
                                 </td>
                                 <td>
                                 </td>
                                 <td>
                                 </td>
                                 <td>
                                 </td>
                                 <td>
                                 </td>
                                 <td class="left-align">
                                   effective resources over ENTIRE project - incl. warranty period:
                                 </td>
                                 <td>
                                   <!-- <input name="backword_effective_days_utilezed" type="text"> -->
                                   <span class="warranty_backword_effective_days_utilezed"></span>
                                 </td>
                                 <td>
                                 </td>
                                 <td>
                                 </td>
                               </tr>
                               <!-- warrenty period phase started here -->
                               <!--  -->
                               <!--  -->
                             </tbody>
              </table>
            </div>
            <div class="estimation-designation-report">
             <label ><input type="checkbox" value="" checked id="chkWarranty" class="warranty-text">With Warranty Period</label>
             <table class="tableData">
               <tr class="head-row">
                 <th>PM</th>
                 <th>Senior/tech lead</th>
                 <th>Designer</th>
                 <th>Front-end dev</th>
                 <th>Back-end dev</th>
                 <th>Testing</th>
                 <th>Total</th>
               </tr>
               <tr>
                 <td><span class="tot-pm totDesignationHrs">0</span></td>
                 <td><span class="tot-tech-lead totDesignationHrs">0</span></td>
                 <td><span class="tot-designer totDesignationHrs">0</span></td>
                 <td><span class="tot-fed totDesignationHrs">0</span></td>
                 <td><span class="tot-bed totDesignationHrs">0</span></td>
                 <td><span class="tot-testing totDesignationHrs">0</span></td>
                 <td><span class="tot-desig-hours">0</span></td>
               </tr>
             </table>
           </div>

           <?php
           $role_id = Session::get('user')[0]['role_id'];
           if ($role_id == 1) {?>
             {!! Form::submit('Submit',array('class' => 'submit-btn')) !!}
             <?php }if ($role_id == 1 || $role_id == 2) {?> <?php }?>
             {!! Form::close() !!}

           </div>
         </div>
       </div>
     </div>
   </div>
   {{-- project timeline ends here --}}
 </div>
 {{--  Planning ends here--}}
</div>

</div>
<script>
  $("#newplan").DataTable({
    "bSort":false,
    "orderable": false,
    "paging": false,
      "scrollY": "500px",
  "scrollCollapse": true,
  });
  var th_width=[];
  $("#newplan th").each(function(){
    var width=$(this).width();
  th_width.push(width);
  });

</script>
@stop
