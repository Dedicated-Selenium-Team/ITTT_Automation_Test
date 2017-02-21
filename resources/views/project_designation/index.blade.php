@extends('master')
<title>ITTT | Project Designation</title>

@section('content')
<!-- project desination page start here -->

<?php $role_id = Session::get('user')[0]['role_id']; ?>
<input type="hidden" value={{$role_id}} id="role-id">

<div class="bread-crumb">
  <div> 
    <a href="/store_project">projects</a>
    <a class="current-page">project designation</a>
  </div>
</div>

<!-- project designation form dropdown list starts here -->
<div class="container-heading cf">
  <div class="designation-CTA cf">
    <a href="/myself" title="Add Myself To A Project" class="assign-project">Add myself to a project</a>
    <!-- <div class="back">
      <a href="/store_project" title="Back">Back</a>
    </div> -->
    <div class="page-title">
      <h2>Project Designation</h2>
    </div>
  </div>
  <div class="designation cf">
    {!! Form::open(array('url' => 'project-values', 'id' => 'project-designation')) !!}
    <div class="select-proj">
      {!! Html::decode(Form::label('select_project','Project<span class="required">*</span>:')) !!}
      {{--  {!!Form::Select('select_project',$list_name,'',array('class' => 'form-control'))!!}
      --}} <p class="error"></p>
      <select class="form-control" id="select_project" name="select_project">
       <option value="0">Please Select Project</option>
       <?php if (($id)) {
         for ($i = 0; $i < count($project_id); $i++) {
          if ($id == $project_id[$i]) {
           echo "<option value='$project_id[$i]' selected>$list_name[$i]</option>";
         } else {

           echo "<option value='$project_id[$i]'>$list_name[$i]</option>";
         }

       }
     }
     ?>
   </select>
 </div>
 <div class="select-designation">
  {!! Html::decode(Form::label('select_designation','Designation<span class="required">*</span>:')) !!}
  {!!Form::Select('select_designation',$designation,'null',array('class' => 'form-control'))!!}
  <p class="error"></p>
</div>
          <!-- <div class="submit cf">
            {!! Form::submit('Go',array('class' => 'submit-btn', 'title' => 'Go')) !!}
          </div> -->
          {!! Form::close() !!}

        </div>
        <div class="total-hrs">
          <h2 class="prj-name">Total number of hours for: <span></span></h2>
          <div class="design-wrap-container">
            <table class="tableData">
              <tr class="head-row">
                <th>actual</th>

                <?php if (($id)) {
                  $estimate_url = "../store_project/estimate/".$id;
                  // $planning_url = "../store_project/planning/".$id;
                  echo "<th>estimate (<a href='$estimate_url' class='estimate-link' title='Click here to see estimation phase estimate details.'>estimation</a>)</th>";
                  echo "<th>estimate (<span class='planning-link'>planning</span>)</th>";
                } else {?>
                 <th>estimate (<a href="#" class="estimate-link" title="Click here to see estimation phase estimate details.">estimation</a>)</th>
                 <th>estimate (<span  class="planning-link">planning</span>)</th>
                 <?php
               }
               ?>
               <th>date span</th>

             </tr>
             <tr>
              <td title="Total number of hours logged between the date span to the right for all users."><span class="actual-hrs"></span></td>
              <td title="Total number of hours based on the estimate done in estimation phase.
              "><span class="estimate-hrs"></span></td>
              <td title="Total number of hours based on the estimate done in planning phase.
              "><span class="planning-hrs"></span></td>
              <td class="dates">
                <span class="start-date" title="Based on the first date actual hours were logged, by any designation. Aka Project Start Date: Actual."></span> -
                <span class="end-date" title="Based on the date all actual hours have been logged until. Keeping in mind that people can log actual hours for future dates."></span>
              </td>
            </tr>
          </table>
          <p class="error">Note: Hours displaying here are excluding warranty period.</p>
        </div>
      </div>
    </div>
    <!-- project designation form dropdown list Ends here -->

    <!-- designation accordian view starts here -->
    <div class="designation-view">
      <!-- Main accordian Starts here -->
      <ul class="cd-accordion-menu animated">
        <!-- PM accordian starts here -->
        <li class="has-children">
          <input type="checkbox" name ="group-1" id="group-1">
          <label for="group-1">Designation: PM</label>
          <ul class="PM">
            <table class="data tableData" data-phase-id="1">
              <thead>
                <tr>
                  <th>Others Working Within Same Designation</th>
                  <th title="Hours you need in percent">% Self Assigned</th>
                  <th title="% Self Assigned / Total of % Self Assigned * 100">% Adjusted</th>
                  <th title="% Adjusted * Estimated Hours">% Adjusted *Estimated (Hrs)</th>
                  <th title="% Adjusted * Planning  Hours">% Adjusted *Planning (Hrs)
                  </th>
                  <th title="Total hours logged in timesheet for this designation">Actuals To-Date</th>
                  <th title="Actuals To-Date / Total of Actuals To-Date * 100">% of Actuals (Hours, Total)</th>
                  <th title="[Actuals To-Date - (% Adjusted * Estimated Hours)]/ (% Adjusted * Estimated Hours)">Actuals / Estimate Ratio</th>
                  <th title="[Actuals To-Date - (% Adjusted * Planning Hours)] / (% Adjusted * Planning Hours)">Actuals / Planning Ratio</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="bold">
                  <td>
                    Total
                  </td>
                  <td>
                    <span class="pre-self-total"></span>
                  </td>
                  <td>
                    <span class="pre-adjusted-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-total"></span>
                  </td>
                  <td>
                    <span class="pre-planig-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-percent-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-ratio-total"></span>
                  </td>
                  <td>
                    <span class="pre-planning-ratio-total"></span>
                  </td>
                </tr>
                <tr class="italic">
                  <td>
                    Remaining
                  </td>
                  <td>
                    <span class="pre-remaining-assign-total"></span>
                  </td>
                  <td>
                  </td>
                  <td>
                    <span class="pre-remaining-estimation-total"></span>
                  </td>
                  <td>
                    <span class="pre-remaining-planning-total"></span>
                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                </tr>
              </tfoot>
            </table>
          </ul>
        </li>
        <!-- PM accordian Ends here -->

        <!-- Designer accordian starts here -->
        <li class="has-children">
          <input type="checkbox" name ="group-2" id="group-2">
          <label for="group-2">Designation: Designer</label>

          <ul class="Designer">
            <table class="data tableData" data-phase-id="2">
              <thead>
                <tr>
                  <th>Others Working Within Same Designation</th>
                  <th title="Hours you need in percent">% Self Assigned</th>
                  <th title="% Self Assigned / Total of % Self Assigned * 100">% Adjusted</th>
                  <th title="% Adjusted * Estimated Hours">% Adjusted *Estimated (Hrs)</th>
                  <th title="% Adjusted * Planning  Hours">% Adjusted *Planning (Hrs)
                  </th>
                  <th title="Total hours logged in timesheet for this designation">Actuals To-Date</th>
                  <th title="Actuals To-Date / Total of Actuals To-Date * 100">% of Actuals (Hours, Total)</th>
                  <th title="[Actuals To-Date - (% Adjusted * Estimated Hours)]/ (% Adjusted * Estimated Hours)">Actuals / Estimate Ratio</th>
                  <th title="[Actuals To-Date - (% Adjusted * Planning Hours)] / (% Adjusted * Planning Hours)">Actuals / Planning Ratio</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="bold">
                  <td>
                    Total
                  </td>
                  <td>
                    <span class="pre-self-total"></span>
                  </td>
                  <td>
                    <span class="pre-adjusted-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-total"></span>
                  </td>
                  <td>
                    <span class="pre-planig-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-percent-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-ratio-total"></span>
                  </td>
                  <td>
                    <span class="pre-planning-ratio-total"></span>
                  </td>
                </tr>
                <tr class="italic">
                  <td>
                    Remaining
                  </td>
                  <td>
                    <span class="pre-remaining-assign-total"></span>
                  </td>
                  <td>
                  </td>
                  <td>
                    <span class="pre-remaining-estimation-total"></span>
                  </td>
                  <td>
                    <span class="pre-remaining-planning-total"></span>
                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                </tr>
              </tfoot>
            </table>
          </ul>
        </li>
        <!-- Designer accordian Ends here -->

        <!-- Front-End Developer accordian starts here -->
        <li class="has-children">
          <input type="checkbox" name ="group-3" id="group-3" class="FE_Developer">
          <label for="group-3">Designation: Front-End Dev</label>
          <ul class="FE_Developer">
            <table class="data tableData" data-phase-id="3">
              <thead>
                <tr>
                  <th>Others Working Within Same Designation</th>
                  <th title="Hours you need in percent">% Self Assigned</th>
                  <th title="% Self Assigned / Total of % Self Assigned * 100">% Adjusted</th>
                  <th title="% Adjusted * Estimated Hours">% Adjusted *Estimated (Hrs)</th>
                  <th title="% Adjusted * Planning  Hours">% Adjusted *Planning (Hrs)
                  </th>
                  <th title="Total hours logged in timesheet for this designation">Actuals To-Date</th>
                  <th title="Actuals To-Date / Total of Actuals To-Date * 100">% of Actuals (Hours, Total)</th>
                  <th title="[Actuals To-Date - (% Adjusted * Estimated Hours)]/ (% Adjusted * Estimated Hours)">Actuals / Estimate Ratio</th>
                  <th title="[Actuals To-Date - (% Adjusted * Planning Hours)] / (% Adjusted * Planning Hours)">Actuals / Planning Ratio</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="bold">
                  <td>
                    Total
                  </td>
                  <td>
                    <span class="pre-self-total"></span>
                  </td>
                  <td>
                    <span class="pre-adjusted-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-total"></span>
                  </td>
                  <td>
                    <span class="pre-planig-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-percent-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-ratio-total"></span>
                  </td>
                  <td>
                    <span class="pre-planning-ratio-total"></span>
                  </td>
                </tr>
                <tr class="italic">
                  <td>
                    Remaining
                  </td>
                  <td>
                    <span class="pre-remaining-assign-total"></span>
                  </td>
                  <td>
                  </td>
                  <td>
                    <span class="pre-remaining-estimation-total"></span>
                  </td>
                  <td>
                    <span class="pre-remaining-planning-total"></span>
                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                </tr>
              </tfoot>
            </table>
          </ul>
        </li>
        <!-- Front-End Developer accordian ends here -->

        <!-- Back-End Developer accordian starts here -->
        <li class="has-children">
          <input type="checkbox" name ="group-4" id="group-4">
          <label for="group-4">Designation: BacK-End Dev</label>
          <ul class="BE_Developer">
            <table class="data tableData" data-phase-id="4" id="be">
              <thead>
                <tr>
                  <th>Others Working Within Same Designation</th>
                  <th title="Hours you need in percent">% Self Assigned</th>
                  <th title="% Self Assigned / Total of % Self Assigned * 100">% Adjusted</th>
                  <th title="% Adjusted * Estimated Hours">% Adjusted *Estimated (Hrs)</th>
                  <th title="% Adjusted * Planning  Hours">% Adjusted *Planning (Hrs)
                  </th>
                  <th title="Total hours logged in timesheet for this designation">Actuals To-Date</th>
                  <th title="Actuals To-Date / Total of Actuals To-Date * 100">% of Actuals (Hours, Total)</th>
                  <th title="[Actuals To-Date - (% Adjusted * Estimated Hours)]/ (% Adjusted * Estimated Hours)">Actuals / Estimate Ratio</th>
                  <th title="[Actuals To-Date - (% Adjusted * Planning Hours)] / (% Adjusted * Planning Hours)">Actuals / Planning Ratio</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="bold">
                  <td>
                    Total
                  </td>
                  <td>
                    <span class="pre-self-total"></span>
                  </td>
                  <td>
                    <span class="pre-adjusted-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-total"></span>
                  </td>
                  <td>
                    <span class="pre-planig-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-percent-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-ratio-total"></span>
                  </td>
                  <td>
                    <span class="pre-planning-ratio-total"></span>
                  </td>
                </tr>
                <tr class="italic">
                  <td>
                    Remaining
                  </td>
                  <td>
                    <span class="pre-remaining-assign-total"></span>
                  </td>
                  <td>
                  </td>
                  <td>
                    <span class="pre-remaining-estimation-total"></span>
                  </td>
                  <td>
                    <span class="pre-remaining-planning-total"></span>
                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                </tr>
              </tfoot>
            </table>
          </ul>
        </li>
        <!-- Back-End Developer accordian Ends here -->

        <!-- Tester accordian starts here -->
        <li class="has-children">
          <input type="checkbox" name ="group-5" id="group-5">
          <label for="group-5">Designation: Tester</label>

          <ul class="Tester">
            <table class="data tableData" data-phase-id="5">
              <thead>
                <tr>
                  <th>Others Working Within Same Designation</th>
                  <th title="Hours you need in percent">% Self Assigned</th>
                  <th title="% Self Assigned / Total of % Self Assigned * 100">% Adjusted</th>
                  <th title="% Adjusted * Estimated Hours">% Adjusted *Estimated (Hrs)</th>
                  <th title="% Adjusted * Planning  Hours">% Adjusted *Planning (Hrs)
                  </th>
                  <th title="Total hours logged in timesheet for this designation">Actuals To-Date</th>
                  <th title="Actuals To-Date / Total of Actuals To-Date * 100">% of Actuals (Hours, Total)</th>
                  <th title="[Actuals To-Date - (% Adjusted * Estimated Hours)]/ (% Adjusted * Estimated Hours)">Actuals / Estimate Ratio</th>
                  <th title="[Actuals To-Date - (% Adjusted * Planning Hours)] / (% Adjusted * Planning Hours)">Actuals / Planning Ratio</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="bold">
                  <td>
                    Total
                  </td>
                  <td>
                    <span class="pre-self-total"></span>
                  </td>
                  <td>
                    <span class="pre-adjusted-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-total"></span>
                  </td>
                  <td>
                    <span class="pre-planig-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-percent-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-ratio-total"></span>
                  </td>
                  <td>
                    <span class="pre-planning-ratio-total"></span>
                  </td>
                </tr>
                <tr class="italic">
                  <td>
                    Remaining
                  </td>
                  <td>
                    <span class="pre-remaining-assign-total"></span>
                  </td>
                  <td>
                  </td>
                  <td>
                    <span class="pre-remaining-estimation-total"></span>
                  </td>
                  <td>
                    <span class="pre-remaining-planning-total"></span>
                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                </tr>
              </tfoot>
            </table>
          </ul>
        </li>
        <!-- Tester accordian Ends here -->

        <!-- Tech Lead Accordian starts here -->
        <li class="has-children">
          <input type="checkbox" name ="group-6" id="group-6">
          <label for="group-6">Designation: Tech Lead</label>

          <ul class="Tech Lead">
            <table class="data tableData" data-phase-id="6">
              <thead>
                <tr>
                  <th>Others Working Within Same Designation</th>
                  <th title="Hours you need in percent">% Self Assigned</th>
                  <th title="% Self Assigned / Total of % Self Assigned * 100">% Adjusted</th>
                  <th title="% Adjusted * Estimated Hours">% Adjusted *Estimated (Hrs)</th>
                  <th title="% Adjusted * Planning  Hours">% Adjusted *Planning (Hrs)
                  </th>
                  <th title="Total hours logged in timesheet for this designation">Actuals To-Date</th>
                  <th title="Actuals To-Date / Total of Actuals To-Date * 100">% of Actuals (Hours, Total)</th>
                  <th title="[Actuals To-Date - (% Adjusted * Estimated Hours)]/ (% Adjusted * Estimated Hours)">Actuals / Estimate Ratio</th>
                  <th title="[Actuals To-Date - (% Adjusted * Planning Hours)] / (% Adjusted * Planning Hours)">Actuals / Planning Ratio</th>
                </tr>
              </thead>
              <tfoot>
                <tr class="bold">
                  <td>
                    Total
                  </td>
                  <td>
                    <span class="pre-self-total"></span>
                  </td>
                  <td>
                    <span class="pre-adjusted-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-total"></span>
                  </td>
                  <td>
                    <span class="pre-planig-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-total"></span>
                  </td>
                  <td>
                    <span class="pre-actual-percent-total"></span>
                  </td>
                  <td>
                    <span class="pre-estimate-ratio-total"></span>
                  </td>
                  <td>
                    <span class="pre-planning-ratio-total"></span>
                  </td>
                </tr>
                <tr class="italic">
                  <td>
                    Remaining
                  </td>
                  <td>
                    <span class="pre-remaining-assign-total"></span>
                  </td>
                  <td>
                  </td>
                  <td>
                    <span class="pre-remaining-estimation-total"></span>
                  </td>
                  <td>
                    <span class="pre-remaining-planning-total"></span>
                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                  <td>

                  </td>
                </tr>
              </tfoot>
            </table>
          </ul>
        </li>
        <!-- Tech Lead Accordian Ends here -->
      </ul>
      <!-- Main accordian ends here -->
    </div>
    <!-- designation accordian ends here -->
    {!! Form::close() !!}
    <!-- project desination ends here -->
    <script type="text/javascript">
    // ajax token starts here
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name = "_token"]').attr('contents')
      }
    });
    // ajax token Ends here

    function hoursData(e) {
      var getProjectName = $('#select_project option:selected').val();
      var estimate_url = "../store_project/estimate/" + getProjectName;
      var planning_url = "../store_project/planning/" + getProjectName;
      $.ajax({
        type: 'POST',
        url: 'getallnumbers/' + getProjectName,
        data: {
          "_token": "{{ csrf_token() }}"
        },
        success: function(data) {
          $('.total-hrs .prj-name span').text($('#select_project option:selected').text());
          $('.total-hrs .actual-hrs').text(Number(data['all_hrs']['total_actual_hrs']).toFixed(2));
          $('.total-hrs .estimate-hrs').text(Number(data['all_hrs']['total_estimate_hrs']).toFixed(2));
          $('.total-hrs .planning-hrs').text(Number(data['all_hrs']['total_planning_hrs']).toFixed(2));
          if (((data['all_hrs']['start_date']) == 0) || ((data['all_hrs']['end_date']) == 0)) {
            $('.total-hrs .start-date').text('');
            $('.total-hrs .end-date').text('');
            $('.total-hrs .dates span').addClass('padding-zero');
          } else {
            $('.total-hrs .start-date').text(data['all_hrs']['start_date']);
            $('.total-hrs .end-date').text(data['all_hrs']['end_date']);
            $('.total-hrs .dates span').removeClass('padding-zero');
          }
          $('.estimate-link').attr('href', estimate_url);
          $('.planning-link').attr('href', planning_url);
        }
      });
    }
    function getDetails(e,project_id,role) {
      var output_array = [];
      var addOnProjectObj = new addOnProjectAfterAssistment();
      var getProjectName = $('#select_project option:selected').val();
      var getProjectDesignation = $('#select_designation').val();
      var designation = $('#select_designation option:selected').text();
      var get_proj = $('#select_project').val();
      var designation = [];
      var getRole = role;
      $.ajax({
       type:'POST',
       data : {
         "_token": "{{ csrf_token() }}"
       },
       url:'getdesig',
       async:false,
       success:function(data)
       {
         for(var i=0;i<(data.designation).length;i++)
         {
           designation.push(data.designation[i])
         }
       }
     });

      var getProjectDesignation=1;
      for(getProjectDesignation;getProjectDesignation<=designation.length;getProjectDesignation++)
      {
       $.ajax({
         type : 'get',
         url :$('#project-designation').attr('action') + '/' + getProjectName + '/' + getProjectDesignation,
         data : {
           'name':getProjectName,
           'id':getProjectDesignation,
           "_token": "{{ csrf_token() }}"
         },
         async: false,
         success: function(data) {
           if((data.name).length==0)
             output_array.push(0);
           else
           {
             data.designation=getProjectDesignation;
             output_array.push(data);
           }
         }
       });
     }
     var getTableData = $('.has-children ul table');

     $(getTableData).each(function () {
      var dataPhaseID = $(this).attr('data-phase-id');
      $(this).find('.employee').remove();
      $(this).find("span[class^='pre']").text("");

    });
     output_array.forEach(function(key,value){
       if (key == 0) {
         var getTableData = $('.has-children ul table');
         $(getTableData).each(function () {
          var dataPhaseID = $(this).attr('data-phase-id');
          if(dataPhaseID==value+1)
          {
           $(this).find('.employee').remove();
           var row="<tr class='empty'><td colspan='9'>No data to show</td></tr>";
           $(this).find('tfoot').remove();
           var length=($(this).find('tr').length);
           if(length==2)
           {

           }
           else
             $(this).append(row);
         }
       });
       } else {
         $(this).find('.empty').remove();
         var getTable = document.getElementsByTagName('table');
         var obj = addOnProjectObj.init(key);
         $('.has-children ul').each(function () {
          var getDesination = $(this).attr('class');

          if (designation == getDesination) {
            $(this).slideDown();
            $(this).parent().find('input[type=checkbox]').prop('checked', true);
            $(this).siblings().addClass('downArrow');
          } else {
            $(this).parent().find('input[type=checkbox]').prop('checked', false);
          }
        });
         var getTableData = $('.has-children ul table');
         var today_date = new Date();
         var today_day = today_date.getDate();
         var today_month = (today_date.getMonth())+1;
         var today_year = today_date.getFullYear();
         var getFullDate = today_year +"-"+today_month+"-"+today_day;
         $(getTableData).each(function () {
           var dataPhaseID = $(this).attr('data-phase-id');
           if (key.designation == dataPhaseID ) {
             $(this).find('.employee').remove();
             for (var i = 0; i < key.name.length; i++) {
              var path = '/time-management/'+getFullDate+'/'+key.projects[i].user_id+'/'+project_id;
              
              if(getRole == 1){
                var row = '<tr class="employee">'+
                '<td><a class="emp-name" href="' + path + '">'+ key.name[i] +'</a>'+
                '</td>'+
                '<td>'+ Number(key.projects[i].required_hrs).toFixed(2) +'%'+'</td>'+
                '<td>'+Number(obj.Adjusted[i]).toFixed(2) +'%'+'</td>'+
                '<td>'+Number(obj.adjustedEstimation[i]).toFixed(2)+'</td>'+
                '<td>'+obj.adjustedPlanning[i]+'</td>'+
                '<td>'+Number(key.timesheet_hrs[i].timesheet_hrs).toFixed(2)+'</td>'+
                '<td>'+Number(obj.actualHours[i]).toFixed(2) +'%'+'</td>'+
                '<td>'+Number(obj.actualEstimationRatio[i]).toFixed(2) +'%'+'</td>'+
                '<td>'+Number(obj.actualPlanningRatio[i]).toFixed(2) +'%'+'</td>'+
                '</tr>';
                $(this).find('.empty').remove();
                $(this).append(row);
              }
              else {
                var row = '<tr class="employee">'+
                '<td>'+ key.name[i] +'</td>'+
                '<td>'+ Number(key.projects[i].required_hrs).toFixed(2) +'%'+'</td>'+
                '<td>'+Number(obj.Adjusted[i]).toFixed(2) +'%'+'</td>'+
                '<td>'+Number(obj.adjustedEstimation[i]).toFixed(2)+'</td>'+
                '<td>'+obj.adjustedPlanning[i]+'</td>'+
                '<td>'+Number(key.timesheet_hrs[i].timesheet_hrs).toFixed(2)+'</td>'+
                '<td>'+Number(obj.actualHours[i]).toFixed(2) +'%'+'</td>'+
                '<td>'+Number(obj.actualEstimationRatio[i]).toFixed(2) +'%'+'</td>'+
                '<td>'+Number(obj.actualPlanningRatio[i]).toFixed(2) +'%'+'</td>'+
                '</tr>';
                $(this).find('.empty').remove();
                $(this).append(row);
              }
            }
            $(this).find('tfoot').remove();
            var footer = '<tfoot><tr class="bold"><td>Total</td><td><span class="pre-self-total"></span></td><td><span class="pre-adjusted-total"></span></td><td><span class="pre-estimate-total"></span></td><td><span class="pre-planig-total"></span></td><td><span class="pre-actual-total"></span></td><td><span class="pre-actual-percent-total"></span></td><td><span class="pre-estimate-ratio-total"></span></td><td><span class="pre-planning-ratio-total"></span></td></tr><tr class="italic"><td>Remaining</td><td><span class="pre-remaining-assign-total"></span</td><td></td><td><span class="pre-remaining-estimation-total"></span></td><td><span class="pre-remaining-planning-total"></span></td><td></td><td></td><td></td><td></td></tr></tfoot>';
            $(this).append(footer);
            console.log('obj', obj);
            $(this).find('.pre-self-total').text((obj.sum).toFixed(2) + "%");
            $(this).find('.pre-adjusted-total').text(Number(obj.gettotAdjusted).toFixed(2) + "%");
            $(this).find('.pre-estimate-total').text((obj.gettotEstimation).toFixed(2));
            $(this).find('.pre-planig-total').text(Number(obj.gettotPlanning).toFixed(2));
            $(this).find('.pre-actual-total').text(Number(obj.gettotAcualToDate).toFixed(2));
            $(this).find('.pre-actual-percent-total').text(Number(obj.getactualTotalHours).toFixed(2) + "%");

            $(this).find('.pre-estimate-ratio-total').text(Number(obj.getactualEstimaionRatio).toFixed(2) + "%");
            $(this).find('.pre-planning-ratio-total').text(Number(obj.getactualPlanningRatio).toFixed(2) + "%");
            $(this).find('.project_name').val(getProjectName);
            $(this).find('.designation_id').val(getProjectDesignation);
            $(this).find('.pre-remaining-assign-total').text(Number(obj.remainingSelfAssignedTotal).toFixed(2) + "%");
            $(this).find('.pre-remaining-estimation-total').text(obj.remainingEstimationTotal);
            $(this).find('.pre-remaining-planning-total').text(Number(obj.remainingPlanningTotal).toFixed(2));
          }
        });
}
});
}
var project_id = $('#select_project').val();

var role = $('#role-id').val();

document.onload = hoursData();
document.onload = getDetails(null,project_id,role);
$('#select_project').on('change', function(e) {
  var project_id = $(this).val();
  e.preventDefault();
  hoursData();
  getDetails(e,project_id,role); 
});

$('#select_designation').on('change', function(e) {
  var getVal = $(this).val();
  console.log('getVal', getVal);
  var gettable = $("[data-phase-id=" + getVal + "]");
  console.log('gettable', gettable);
  $('html, body').animate({
    scrollTop: gettable.parent().parent().offset().top
  }, 2000)
});
</script>
@stop