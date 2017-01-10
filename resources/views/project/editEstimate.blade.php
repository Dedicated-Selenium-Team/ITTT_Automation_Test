@extends('master')
<title>ITTT | Estimation</title>

{{-- This will check the User session and if admin then edit the planning and if not admin then only view Starts here--}}

<?php
$role_id = Session::get('user')[0]['role_id'];
if ($role_id == 2)
 {?>
  <div class="user">
<?php }
   else
    echo "<div>";
  ?>
   {{-- This will check the User session and if admin then edit the planning and if not admin then only view Ends here--}}
   @section('content')

   <div class="bread-crumb">
  <div>
    <a href="/store_project">Projects</a>
    <?php 
    $prev_page = $_SERVER['HTTP_REFERER'];
    if(strpos($prev_page, 'project-designation') !== false){
      ?>
      <a href="{{ URL::previous() }}">Project Designation</a>
      <a class="current-page">estimation</a>
    </span>
    <?php } else { ?>
      <a class="current-page">estimation</a>
    </span>
    <?php } ?>
  </div>
</div>

  <div class="text-capitalize">
    <!-- Estimate starts here -->
    <div class="edit-estimation-form">
          {!! Form::open(array('route' => ['submitEstimate', 'id' => $unique_id])) !!}

      <div class="estimate-plan">
        <!-- project phase starts here -->
        <div class="project-phase">
          <div class="phase-heading container-heading cf">
            <!-- <div class="back">
              <a href="{{ URL::previous() }}" title="Back">Back</a>
            </div> -->
            <div class="page-title">
              <h2>Estimation</h2>
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
                {!! Form::text('project-start-date',$set_estimate[0]['start_date'],array('class' => 'startDate phaseCalculation form-control datepicker','readonly')) !!}
              </div>
              <div class="proj-date-snipet">
                {!! Form::label('phase-I-end-date', 'Phase 1 End Date:') !!}
                {!! Form::text('phase-I-end-date', $set_estimate[0]['p_I_live'],['class' => 'p1Date phaseCalculation form-control datepicker','readonly']) !!}
              </div>
              <div class="proj-date-snipet">
                {!! Form::label('phase-II-end-date', 'Phase 2 End Date:') !!}
                {!! Form::text('phase-II-end-date', $set_estimate[0]['p_II_live'],['class' => 'p2Date phaseCalculation form-control datepicker','readonly']) !!}
              </div>
              <div class="proj-date-snipet numericValidation">
                {!! Form::label('Warrenty-days', 'Warranty days:') !!}
                {!! Form::text('Warrenty-days',$set_estimate[0]['warranty_days'],['class' => 'warranty-days phaseCalculation form-control']) !!}
                <p class="note">Warranty days should not exceed more than 100 days.</p>
              </div>
              <div class="proj-date-snipet">
                {!! Form::label('Warrenty-period-end', 'Warranty End date:') !!}
                {!! Form::text('Warrenty-period-end',$set_estimate[0]['warrenty_period'],['class' => 'warrantyDate phaseCalculation form-control','disabled']) !!}
              </div>
              <div class="proj-date-snipet numericValidation">
                {!! Form::label('Warrenty-period-holiday', 'Holiday:') !!}
                {!! Form::text('Warrenty-period-holiday',$set_estimate[0]['holidays'],['class' => ' holiday phaseCalculation form-control']) !!}
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
                {!! Form::text('resources',$set_estimate[0]['expected_resources'],['class' => 'resources calculated phaseCalculation form-control'])!!}
                <p class="note">Number of resources should not exceed more than 15.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- project phase ends here -->
      </div>
      <!-- testing starts here -->
      <!-- Modal content start-->
      <div class="modal-content display">
        <div class="modal-header">
         <h1 class="modal-title">Event for Day</h1>
        </div>
        <div class="modal-body">
          {!! Form::open(['url' => '#']) !!}
          <div class="phase-list" id="phase-list">
          <div class="form-group cf">
            {!!Form::label('phase', 'Select Phase');!!}
            {!!Form::Select('phase',$phase);!!}
            {!! Form::hidden('phase-id', '', array('class' => 'phase-id')) !!}
          </div>
          <div class="form-group cf">
            {!!Form::label('designation', 'Select Designation');!!}
            <select id="ddlDesignaionName">
              <option value="1">PM</option>
              <option value="2">Tester</option>
              <option value="3">FE_Developer</option>
              <option value="4">BE_Developer</option>
            </select>
          </div>
          </div>
        <div class="modal-footer">
        <div class="save-project">
          <div class="form-group cf">
            <a href="#FIXME" id="desig" class="designation-btn add-designation">Click Here
            </a>
          </div>
        </div>
        </div>
      </div>
      </div>
  <!-- Modal content end -->


  <!-- testinf ends here -->
  <!-- project timeline starts here -->
  <div class="numericValidation project-timeline">
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
                  <table class="estimation-report tableData th-border" id="edit_estimate">
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
         <?php
         $total_phases=count($data['phase']);
         $count=1;
         foreach($data['phase'] as $key=>$value)
         {
          $phase_name=$key;
          $phase_id=$value['phase_id'];
          $spent_days= $value['spent_days'];
          $name_to_display=$value['display_name'];
          $tmp=$total_phases-$count;
          if($tmp<'1')
          {
            echo "<tr class='light-green'>
            <th>
             Timeline to LIVE (calc):
           </th>
           <td>
             <span class='t2live_timeline_days'></span>
           </td>
           <td>
            <span class='t2live_timeline_months'></span>
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
           <span class='t2live_effective_days_utilezed'></span>
         </td>
         <td>
           <span class='t2live_hrs_cal'></span>
         </td>
         <td></td>
       </tr>";
       
       echo "<tr class='light-green'>
       <td>
         Backwards working:
       </td>
       <td>
         <span class='backword_timeline_days'></span>
       </td>
       <td>
        
       </td>
       <td>
        
       </td>
       <td>
        
       </td>
       <td>
        
       </td>
       <td class='left-align'>
         effective resources over project until LIVE - NOT incl. of warranty period:
       </td>
       <td>
         <span class='backword_effective_days_utilezed'></span>
       </td>
       <td>
        
       </td>
       <td>
        
       </td>
     </tr>";
     
   }
   
   echo "<tr class='light-orange'>
   <th data-phase-id='$phase_id'>$name_to_display
    <input type='hidden' name='phase[$name_to_display][phase_id]' value='$phase_id'></th>";
    if($tmp<'1')
    {
      
      echo "<td><input type='text' value='$spent_days' class='$key  wtot triggerWarranty' name='phase[$name_to_display][spent_days]'></td>
      <td><span class='".$key."_month ".$key."timelineMonths'></span></td><td></td><td></td><td></td>";
    }
    else
    {
      echo "<td><input type='text' value='$spent_days' class='$key timelineDays' name='phase[$name_to_display][spent_days]'></td>";
      
      echo "<td><span class='".$key."_month timelineMonths'></span></td>
      <td></td><td></td><td></td>";
    }
    echo "<td><span class='".$key."_effective_resources eResources'></span></td>";
    if($tmp<'1')
    {
      echo "<td><span class='".$key."_effective_days_utilezed eWDays'></span></td><td><span class='".$key."_hrs_cal'></span></td>
      <td></td></tr>";
    }
    else
    {
      echo "<td><span class='".$key."_effective_days_utilezed eDays'></span></td>";
      echo "<td><span class='".$key."_hrs_cal phaseHourCal'></span></td>
      <td></td></tr>";
    }
    
    foreach($value as $phase_detail_key=>$phase_detail_value)
      if(is_array($phase_detail_value))
      {
        foreach($phase_detail_value  as $designation=>$designation_info)
        {
          if(is_array($designation_info))
          {
            foreach($designation_info as $key1=>$designation_detail)
            {
              $lower_desig=strtolower($key1);
              
              echo "<tr><td>$key1
              <input type='hidden' value='$designation_detail[row_id]' name='phase[$name_to_display][designations][$designation][$key1][row_id]'>
              <input type='hidden' value='$designation_detail[d_id]' name='phase[$name_to_display][designations][$designation][$key1][d_id]'>
            </td>
            <td></td><td></td><td></td>";
            echo "<td><input type='text' class='$key hrsLimit $lower_desig-hrs' value='$designation_detail[per_day_hours]' name='phase[$name_to_display][designations][$designation][$key1][per_day_hours]'></td>
            <td><span class='".$lower_desig."_work_per_day'></span></td>
            <td></td>
            <td></td>
            <td><span class='".$lower_desig."-calc-hrs'></span></td>
            <td></td>
          </tr>";
                                    //foreach($designation_detail as $designation_detail_key=>$designation_detail_value)
          
        }
        
                                    /*$d_id=$designation_info['d_id'];
                                    $hours=$designation_info['per_day_hours'];
                                    $row_id=$designation_info['row_id'];
                                    echo "data is $d_id and $hours and row id is $row_id<br>";*/
                                    
                                  }
                                }
                              }
                              
                              
                                    //print_r($phase_detail_value);
                              $count++;
                            }
                            echo '<tr class="light-green">
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
                        </tr>';
                        echo '<tr class="light-green">
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
                      </tr>';
                      
                      ?>
                      <!-- warrenty period phase started here -->
                      <!--  -->
                      <!--  -->
                      <!-- warrenty period ends here -->
                    </tbody>
                  </table>
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
     <th>total</th>
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
</div>
</div>
</div>
</div>
</div>
</div>
<!-- project timeline ends here -->
</div>
<!--  Estimate ends here-->
</div>
{!! Form::close() !!}
</div>
</div>

<script type="text/javascript">
  $("#edit_estimate").DataTable({
    "bSort":false,
    "orderable": false,
    "paging": false,
      "scrollY": "500px",
  "scrollCollapse": true,
  });
  var th_width=[];
  $("#edit_estimate th").each(function(){
    var width=$(this).width();
  th_width.push(width);
  });

</script>
</div>
@stop
