@extends('master')
<title>ITTT | Add Myself To A Project</title>

@section('content')
<?php
$role_id   = Session::get('user')[0]['role_id'];
$user_id   = Session::get('user')[0]['user_id'];
$user_name = Session::get('user')[0]['first_name'];
?>

<div class="bread-crumb">
  <div>
    <?php 
    $prev_page = $_SERVER['HTTP_REFERER'];
    if(strpos($prev_page, 'project-designation') !== false){
      ?>
      <a href="/store_project">Projects</a>
      <a href="{{ URL::previous() }}">Project Designation</a>
      <?php } else if(strpos($prev_page, 'time-management') !== false) { ?>
       <a href="{{ URL::previous() }}">Timesheet</a>
       <?php } else { ?>
        <a href="/store_project">Projects</a>
        <?php } ?>
        <a class="current-page">Add Myself To A Project</a>
      </div>
    </div>

    <!-- container heading for addmyself starts here -->

    {!! Form::open(array('url' => 'myself/project-details', 'id' => 'assign-project')) !!}
    <div class="container-heading cf">
  <!-- <div class="designation-CTA cf">
    <div class="back">
      <a href="{{ URL::previous() }}" title="Back">Back</a>
    </div>
  </div> -->
  <div class="designation cf">
    <div class="select-proj">
      {!! Html::decode(Form::label('project_name','Project<span class="required">*</span>:')) !!}
      <select class="form-control" name="select_project" id="project_name" class="getProject">
       <option value="0">Please Select Project</option>
       @for($i=0;$i<count($project_id);$i++)
       <option value="{{$project_id[$i]}}">{{$project_list[$i]->project_name}}</option>
       @endfor
       <?php if ($role_id == 1) {?>
         <option value ="newProjet" data-toggle="modal" data-target="#create-project">Add New Project</option>
         <?php } ?>
         <!-- <a href="#FIXME" title="Add New Project" class="addProject" data-toggle="modal" data-target="#create-project">Add New Project</a -->>
       </select>
       <p class="error"></p>
       <p class="message"></p>
     </div>
     <div class="select-designation">
      {!! Html::decode(Form::label('designation','Designation<span class="required">*</span>:')) !!}
      {!!Form::Select('select_designation',$designation,'null',array('class' => 'form-control', 'id' => 'designation'))!!}
      <p class="error"></p>
    </div>
    <div class="submit cf">
      {!! Form::submit('Submit',array('class' => 'submit-btn','title' => 'Submit')) !!}


    </div>
    <!-- Add New Project Modal Ends Here-->
  </div>
</div>
{!! Form::close() !!}
<!-- container heading for addmyself Ends here -->
<!-- Add New Project Modal Starts Here-->
<div class="modal fade create-new-project modal-error-off" id="create-project" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content Starts Here-->
    <div class="modal-content">

      {!! Form::open(array('id' => 'add-project', 'method' => 'post')) !!}

      <!-- Modal Header Starts Here -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1 class="modal-title">Create New Project</h1>
      </div>
      <!-- Modal Header Ends Here -->

      <!-- Modal Body Starts Here -->
      <div class="modal-body">

        <div class="form-group cf">
          {!! Html::decode(Form::label('project_name1','Project Name<span class="required">*</span>:')) !!}
          {!! Form::text('project_name1', Input::old('project_name'), array('class' => '','placeholder' =>'Project name')) !!}
          <p class="error"></p>
        </div>

        <div class="form-group cf">
          {!! Html::decode(Form::label('project_code','Project Code:')) !!}
          {!! Form::text('project_code', Input::old('project_name'), array('placeholder' =>'Project code')) !!}
          <p class="error"></p>
        </div>

        <div class="form-group cf">
          {!! Html::decode(Form::label('client_name','Client Name<span class="required">*</span>:')) !!}
          {!! Form::text('client_name', Input::old('client_name'), array('placeholder' =>'Client name')) !!}
          <p class="error"></p>
        </div>

        <div class="form-group cf">
         {!! Html::decode(Form::label('status_id','Project Status:')) !!}
         <select class="status_id" name="status_id" >
           <option value="1">Estimates</option>
           <option value="2">Live-Projects</option>
           <option value="3">Live-Ongoing</option>
         </select>
       </div>
       
     </div>
     <!-- Modal Body Ends Here -->

     <!-- Modal Footer Starts Here -->
     <div class="modal-footer">
      <div class="save-project">
        {!! Form::submit('Submit')!!}
      </div>
    </div>
    <!-- Modal Footer Ends Here -->
    {!! Form::close() !!}

  </div>
  <!-- Modal content Starts Here-->

  {!! Form::close() !!}
</div>

</div>
<div class="designation-detail">
  <div class="container-heading">
    <span class="table-heading camle-case">
      Total Hours Related to this Designation:
    </span>
  </div>
  <div class="designation-detail-data designation-table numericValidation cf">
    <div class="design-wrap-container">
      {!! Form::open(array('url' => 'addself/project-details', 'id' => 'project_hrs')) !!}
      <!-- This code is commented because this code is nessesary for backend perspective starts here -->
      <!-- start's here -->
      <div class="form-group cf display">
        {!! Form::label('p_name', 'Project:') !!}
        {!!Form::text('p_name',' ',array('class' => 'project_name'))!!}
      </div>
      <div class="form-group cf display">
        {!! Form::label('designation', 'Designation:') !!}
        {!!Form::text('designation',' ',array('class' => 'designation_id'))!!}
      </div>
      <!-- Ends's here -->
      <!-- This code is commented because this code is nessesary for backend perspective Ends here-->
      <table class="tableData cell-middle desig-table">
       <tr class="head-row">
         <th>
           Estimation (Hrs):
         </th>
         <th>
           Planning (Hrs):
         </th>
         <th>
           Actuals (Hrs)
         </th>
         <th>
           Hours You need
         </th>
         <th>
           % Of Hours You Need
         </th>
       </tr>
       <tr>
        <td>
          {!!Form::text('client Hours',' ',array('class' => 'appHours input-read', 'disabled'))!!}
        </td>
        <td>
          {!!Form::text('Post Estimation','',array('class' => 'PostAppHours input-read', 'disabled'))!!}
        </td>
        <td>
          {!!Form::text('Actuals ','',array('class' => 'actualAppHours input-read', 'disabled'))!!}
        </td>
        <td>
          {!!Form::text('hours',' ',array('class' => 'hoursNeed','placeholder' => 'Your hrs'))!!}
        </td>
        <td>
          {!!Form::text('percent',' ',array('class' => 'percentHoursNeed','disabled'))!!}
        </td>
      </tr>
    </table>
    <p class="error">Note: Hours displaying here are excluding warranty period.</p>
    {!! Form::submit('Check',array('class' => 'submit-btn','title' => 'Check')) !!}
    {!! Form::close() !!}
  </div>
</div>
</div>

<!-- Before Assistment start here -->
<div class="designation-detail before-self-assign">
  <div class="container-heading">
    <span class="table-heading">
      Before self-assignment:
    </span>
  </div>
  <div class="designation-detail-data designation-table before-assign cf">
    <table class="table-body tableData pre-table-body">
      <thead>
        <tr class="head-row">
          <th>
            Others Working Within Same Designation
          </th>
          <th title="Hours you need in percent">
            % Self Assigned
          </th>
          <th title="% Self Assigned / Total of % Self Assigned * 100">
            % Adjusted
          </th>
          <th title="% Adjusted * Estimated Hours">
            % Adjusted *Estimated (Hrs)
          </th>
          <th title="% Adjusted * Planning  Hours">
            % Adjusted *Planning (Hrs)
          </th>
          <th title="Total hours logged in timesheet for this designation">
            Actuals To-Date
          </th>
          <th title="Actuals To-Date / Total of Actuals To-Date * 100">
            % of Actuals (Hours, Total)
          </th>
          <th title="[Actuals To-Date - (% Adjusted * Estimated Hours)]/ (% Adjusted * Estimated Hours)">
            Actuals / Estimate Ratio
          </th>
          <th title="[Actuals To-Date - (% Adjusted * Planning Hours)] / (% Adjusted * Planning Hours)">
            Actuals / Planning Ratio
          </th>
        </tr>
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
      </thead>
    </table>
  </div>
</div>
<!-- Before Assistment ends here -->

<!-- After assistment starts here -->
<div class="designation-detail after-self-assign">
  <div class="container-heading">
    <span class="table-heading">
      Post self-assignment:
    </span>
  </div>
  <div class="designation-detail-data designation-table before-assign cf">
   <table class="post-table-body tableData">
    <thead>
      <tr class="head-row">
        <th>
          Others Working Within Same Designation
        </th>
        <th title="Hours you need in percent">
          % Self Assigned
        </th>
        <th title="% Self Assigned / Total of % Self Assigned * 100">
          % Adjusted
        </th>
        <th title="% Adjusted * Estimated Hours">
          % Adjusted *Estimated (Hrs)
        </th>
        <th title="% Adjusted * Planning  Hours">
          % Adjusted *Planning (Hrs)
        </th>
        <th title="Total hours logged in timesheet for this designation">
          Actuals To-Date
        </th>
        <th title="Actuals To-Date / Total of Actuals To-Date * 100">
          % of Actuals (Hours, Total)
        </th>
        <th title="[Actuals To-Date - (% Adjusted * Estimated Hours)]/ (% Adjusted * Estimated Hours)">
          Actuals / Estimate Ratio
        </th>
        <th title="[Actuals To-Date - (% Adjusted * Planning Hours)] / (% Adjusted * Planning Hours)">
          Actuals / Planning Ratio
        </th>
      </tr>
      <tr class="bold">
        <td>
          Total
        </td>
        <td>
          <span class="post-self-total"></span>
        </td>
        <td>
          <span class="post-adjusted-total"></span>
        </td>
        <td>
          <span class="post-estimate-total"></span>
        </td>
        <td>
          <span class="post-planig-total"></span>
        </td>
        <td>
          <span class="post-actual-total"></span>
        </td>
        <td>
          <span class="post-actual-percent-total"></span>
        </td>
        <td>
          <span class="post-estimate-ratio-total"></span>
        </td>
        <td>
          <span class="post-planning-ratio-total"></span>
        </td>
      </tr>
      <tr class="italic">
        <td>
          Remaining
        </td>
        <td>
          <span class="post-remaining-assign-total"></span>
        </td>
        <td>
        </td>
        <td>
          <span class="post-remaining-estimation-total"></span>
        </td>
        <td>
          <span class="post-remaining-planning-total"></span>
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
    </thead>
  </table>
  {!! Form::open(array('url' => array('/store-self-project', $user_id), 'id' => 'my-project')) !!}
  <div class="form-group cf display">
    {!! Form::label('project_name', 'Project Name :') !!}
    {!!Form::text('project_name',' ',array('class' => 'project_name'))!!}
  </div>
  <div class="form-group cf display">
    {!! Form::label('designation_id', 'Designation :') !!}
    {!!Form::text('designation_id',' ',array('class' => 'designation_id'))!!}
  </div>
  <div class="form-group cf display">
    {!! Form::label('req_hrs', 'Required Hrs :') !!}
    {!!Form::text('req_hrs',' ',array('class' => 'req_hrs'))!!}
  </div>
  <div class="center form-group cf">
    {!! Form::submit('Submit',array('class' => 'submit-btn','title' => 'Submit')) !!}
  </div>
  {!! Form::close() !!}

</div>
</div>
<!-- After assistment end's here -->
</div>
<script type="text/javascript">
  $.ajaxSetup({
    headers : {
      'X-CSRF-TOKEN' : $('meta[name = "_token"]').attr('contents')
    }
  });
  
  $('#my-project').on('submit', function(e) {
    var projectName = $('#project_name').val();
    var projectDesignation = $('#designation_id').val();
    var projectHrs = $('#req_hrs').val();

    if (projectName == 0 || projectDesignation == 0 ) {
      return false;
    } else {
      return true ;
    }
  });
  
  // Assign project functionality starts here
  $('#assign-project').on('submit', function(e) {
    e.preventDefault();
    var desig_index = $('#designation')[0].selectedIndex;
    var project_index = $('#project_name option:selected').val();
    if(desig_index !=0 && project_index != 0 && project_index != 'newProjet') {
      $('html, body').animate({
        scrollTop: $('.designation-detail').offset().top }, 1000);
    }

    if(project_index=='newProjet'){
      $('.designation #project_name').siblings('.message').text('Please select project name');
      $('.designation #project_name').siblings('.message').show();
    }

    var clickValue = $(this).attr('id');
    var testObj  = new addOnProject(clickValue);

    $('.table-body').find('.employee').remove();
    var getProjectName = $('#project_name option:selected').val();
    var value1 = $('#designation').val();
    var url = $('#assign-project').attr('action') + '/' + project_index + '/' + value1;
    $.ajax({
      type : 'post',
      url : url,
      data : {
        'name':getProjectName,
        'id':value1,
        "_token": "{{ csrf_token() }}"
      },
      success: function(data) {
        $('table').find('.employee').remove();
        $('.post-table-body span').empty();
        var testing  = testObj.init(data);

        for (var i = 0; i < data.name.length; i++) {
          var row = '<tr class="employee">'+
          '<td>'+ data.name[i] +'</td>'+
          '<td>'+ data.projects[i].required_hrs +'%'+'</td>'+
          '<td>'+Number(testing.Adjusted[i]).toFixed(2)+"%"+'</td>'+
          '<td>'+testing.adjustedEstimation[i]+'</td>'+
          '<td>'+testing.adjustedPlanning[i]+'</td>'+
          '<td>'+Number(data.timesheet_hrs[i].timesheet_hrs).toFixed(2)+'</td>'+
          '<td>'+Number(testing.actualHours[i]).toFixed(2)+"%"+'</td>'+
          '<td>'+Number(testing.actualEstimationRatio[i]).toFixed(2)+"%"+'</td>'+
          '<td>'+Number(testing.actualPlanningRatio[i]).toFixed(2)+"%"+'</td>'
          '</tr>';
          $('.table-body tr').eq(-2).before(row);
        }
        $('.appHours').val(Number(data.hrs).toFixed(2));
        $('.PostAppHours').val(Number(data.plan_hrs).toFixed(2));
        $('.actualAppHours').val(Number(data.actual_hrs).toFixed(2));
        $('.pre-self-total').text((testing.sum).toFixed(2) + "%");
        $('.pre-adjusted-total').text(Number(testing.gettotAdjusted).toFixed(2) + "%");
        $('.pre-estimate-total').text(testing.gettotEstimation.toFixed(2));
        $('.pre-planig-total').text(testing.gettotPlanning.toFixed(2));
        $('.pre-actual-total').text(Number(testing.gettotAcualToDate).toFixed(2));
        $('.pre-actual-percent-total').text(Number(testing.getactualTotalHours).toFixed(2) + "%");
        $('.pre-planning-ratio-total').text(Number(testing.getactualPlanningRatio).toFixed(2) + "%");
        $('.project_name').val(getProjectName);
        $('.designation_id').val(value1);

        $('.pre-estimate-ratio-total').text(Number(testing.getactualEstimaionRatio).toFixed(2) + "%");
      // Remaing row calculation Printing //

      $('.pre-remaining-assign-total').text(Number(testing.remainingSelfAssignedTotal).toFixed(2) + "%");
      $('.pre-remaining-estimation-total').text(Number(testing.remainingEstimationTotal).toFixed(2));
      $('.pre-remaining-planning-total').text(Number(testing.remainingPlanningTotal).toFixed(2));
    }
  });

  });
// Assign project functionality Ends here

// project_hrs functionality starts here
$("#project_name").on('change',function()
{
  $('.percentHoursNeed').val("0.00");
  var project_index = $('#project_name option:selected').val();
  if(project_index != 'newProjet'){
    $('.designation #project_name').siblings('.message').text('');
    $('.designation #project_name').siblings('.message').hide();
  }
});
$('#project_hrs').on('submit', function(e) {
  e.preventDefault();
  var hours=Number($(".hoursNeed").val());
  var planninghrs=Number($(".PostAppHours").val());
  var estimationhrs=Number($(".appHours").val());
  
  $('.post-table-body').find('.employee').remove();
  var clickValue = $(this).attr('id');
  var object = new addOnProjectAfterAssistment();
  var userName = " <?php echo $user_name?>";
  var getProjectName = $('#project_name').val();

  var value1 = $('#designation').val();
  var hrs = $('.percentHoursNeed').val();
  if(hrs.length==1)
    $('.req_hrs').val("0.00");
  else
    $('.req_hrs').val(hrs);
  var url = $('#project_hrs').attr('action') + '/' + getProjectName + '/' + value1 + '/' + hrs;

  $.ajax({
    type : 'get',
    url : url,
    data : {
      'name':getProjectName,
      'id':value1,
      'hrs':hrs,
      'user_name':userName,
      "_token": "{{ csrf_token() }}"
    },
    success:function(data){
      var currentName;
      var getNewUserData = object.init(data);
      for (var i = 0; i < data.name.length; i++) {
        var row = '<tr class="employee">'+
        '<td>'+ data.name[i] +'</td>'+
        '<td>'+ data.projects[i].required_hrs +'%'+'</td>'+
        '<td>'+Number(object.Adjusted[i]).toFixed(2)+"%"+'</td>'+
        '<td>'+object.adjustedEstimation[i]+'</td>'+
        '<td>'+object.adjustedPlanning[i]+'</td>'+
        '<td>'+Number(data.timesheet_hrs[i].timesheet_hrs).toFixed(2)+'</td>'+
        '<td>'+Number(object.actualHours[i]).toFixed(2)+"%"+'</td>'+
        '<td>'+Number(object.actualEstimationRatio[i]).toFixed(2)+"%"+'</td>'+
        '<td>'+Number(object.actualPlanningRatio[i]).toFixed(2)+"%"+'</td>'
        '</tr>';
        $('.post-table-body tr').eq(-2).before(row);
      }
      $('.post-self-total').text(object.sum.toFixed(2) + "%");
      $('.post-adjusted-total').text(Number(object.gettotAdjusted).toFixed(2) + "%");
      $('.post-estimate-total').text(object.gettotEstimation.toFixed(2));
      $('.post-planig-total').text(object.gettotPlanning.toFixed(2));
      $('.post-actual-total').text(Number(object.gettotAcualToDate).toFixed(2));
      $('.post-actual-percent-total').text(Number(object.getactualTotalHours).toFixed(2) + "%");
      $('.post-estimate-ratio-total').text(Number(object.getactualEstimaionRatio).toFixed(2) + "%");
      $('.post-planning-ratio-total').text(Number(object.getactualPlanningRatio).toFixed(2) + "%");

      $('.post-remaining-assign-total').text(Number(object.remainingSelfAssignedTotal).toFixed(2) + "%");
      $('.post-remaining-estimation-total').text(Number(object.remainingEstimationTotal).toFixed(2));
      $('.post-remaining-planning-total').text(Number(object.remainingPlanningTotal).toFixed(2));
    }
  });

  var hoursNeed_index = $('.hoursNeed').val();
  var appHours_index = $('.appHours').val();
  if(hoursNeed_index != ' ' && appHours_index != ' ') {
    $('html, body').animate({
      scrollTop: $('.before-self-assign').offset().top }, 1000);
  }
  
});

$(document).on("click", '#project_name', function () {
  var data = $(this).val();
  console.log('data', data);
  if (data == "newProjet") {
    $("#create-project").modal('show');
  }
});
// project_hrs functionality Ends here

var blurHappened = false;

$('#project_name1').on('blur', function(e){
 if (blurHappened)
 {
  blurHappened = false;
}
else 
{
  e.preventDefault();
  var project_name=$("#project_name1").val();
  $.ajax({
   type : 'get',
   url : '/duplicate_project',
   data : {'project_name':project_name},
   success : function(data) {
     console.log('data', data);
     if(data.duplicate_project_status==1){
      $('#project_name1').siblings('.error').text('Entered project name is already exist');
      $('#project_name1').siblings('.error').show();
    }
    else{
     console.log('no message')
   }
 }
});
}

});

$('#add-project').on('submit',function(e) {
  e.preventDefault();
  blurHappened = true;
  var project_name=$("#project_name1").val();
  var project_code=$("#project_code").val();
  var client_name=$("#client_name").val();
  var project_status=$(".status_id").val();
  $.ajax({
    type:'post',
    url:'/project_info',
    data:{'project_name':project_name,'project_code':project_code,'client_name':client_name,'status_id':project_status},
    success:function(data)
    { 
      if(data.duplicate_project_status==1){
        $('#project_name1').siblings('.error').text('Entered project name is already exist');
        $('#project_name1').siblings('.error').show();
      }
      else {
        location.href='/store_project';
      }
    }
  });
});

</script>
</div>
@stop
