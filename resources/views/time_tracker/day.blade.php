@extends('master')
<title>ITTT | Timesheet</title>

@section('content')

<?php $role_id = Session::get('user')[0]['role_id']; ?>
<div class="day-timesheet">

  <div class="container-heading cf">
    <?php
    $week_date = date('Y, F j', strtotime('monday this week'));
    $today     = date('Y-m-d');
    $prev_date = date('Y-m-d', strtotime($date.' -1 day'));
    $next_date = date('Y-m-d', strtotime($date.' +1 day'));
    ?>

    <input type="hidden" name="date" value="{{date('l, F j, Y', strtotime($date))}}" class="border-style input-read-only" id="date">
    <span class="border-style input-read-only">{{date('l, F j, Y', strtotime($date))}}</span>

    <div class="timesheet-header-right">
      <a href="/time-management/{{$today}}" class="today"  title="Today">Today</a>

      <div class="arrow">
       <a href="/time-management/{{$prev_date}}" class="previous" title="Previous">Previous</a>
       <a href="/time-management/{{$next_date}}" class="next" title="Next">Next</a>
     </div>

     <input class="date-pick" placeholder="DD/MM/YYYY" readonly="readonly" name="joining_date" type="text" value="" id="joining_date" title="Datepicker">

     <div class="views">
       <a href="/time-management/{{$today}}" title="Day View" class="day active-view">Day</a>
       <a href="/time-management/week/<?=$week_date;?>" title="Week View" class="week">Week</a>
     </div>

   </div>
 </div>

 <div class="modal fade create-project modal-error-off" id="create-project" role="dialog">
   <div class="modal-dialog">

     <!-- Modal content start-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h1 class="modal-title">Event for Day</h1>
       </div>
       <div class="modal-body">

         {!! Form::open(array('url' => 'store-time', 'id' => 'project-day-time')) !!}

         <div class="form-group cf display">
           {!! Form::label('date', 'Date: ') !!}
           {!! Form::text('date', date('Y-m-d', strtotime($date)), array('class' => '')) !!}
           <p class="error"></p>
         </div>
         {!! Form::hidden('row_id', '',array('id'=>'row_id'))!!}
         <div class="form-group cf">
           {!! Html::decode(Form::label('project_name','Project / Task:')) !!}
           <select class="project-ddl" name="project_id" id="project">
             <option value="0">Please Select Project</option>
             @foreach($projects as $key=>$value)
             <option value="{{$value['project_id']}}">{{$value['project_name']}}</option>
             @endforeach
             <option value="other">Add Myself To a Project</option>
           </select>
           {!! $errors->first('project_name', '<div class="message">*:message</div>') !!}
           <p class="error"></p>
         </div>

         <div class="form-group cf">
          <select class="project-ddl" name="project_desig" id="project_desig">
           <option value="0">Please Select Designation</option>
           <option value="1">PM</option>
           <option value="2">Designer</option>
           <option value="3">FE_Developer</option>
           <option value="4">BE_Developer</option>
           <option value="5">Tester</option>
           <option value="6">Tech Lead</option>
         </select>
         <p class="error"></p>
       </div>

       <div class="form-group cf">
         <!-- {!! Form::label('comments', 'Enter Task For The Day: ') !!} -->
         {!! Form::textarea('comments', '', array('class' => 'comment helper', 'size' => '26x5', 'placeholder' => 'Enter Task For The Day')) !!}
         <p class="error"></p>
         <p class="note">The maximum limit to enter the task for a day is 1000 characters</p>
       </div>

       <div class="form-group cf">
         <!-- {!! Form::label('hrs_locked', 'Enter Hours To Complete Task: ') !!} -->
         {!! Form::text('hrs_locked', Input::old('client_name'), array('placeholder' => 'Enter Hours To Complete Task', 'class' => 'helper hrs-locked')) !!}
         {!! Form::hidden('hidden_Hrs', '',array('id'=>'hidden_Hrs'))!!}
         <p class="error"></p>
         <p class="note">You can also enter time as 1.5 or 1:30 (they both mean 1 hour and 30 minutes)</p>
       </div>
       <div class="form-group cf">
         <!-- {!! Form::label('hrs_locked', 'Enter Hours To Complete Task: ') !!} -->
       </div>

     </div>
     <div class="modal-footer">
       <div class="save-project">
         <!-- <a href="/myself" title="Add Myself To A Project" class="assign-project">Add myself to a project</a> -->
         {!! Form::submit('Submit', array('id'=>'save','class'=>'hrs-modified')) !!}
       </div>
     </div>
   </div>
   <!-- Modal content end -->
   {!! Form::close() !!}

 </div>
</div>

{{-- end of modal demo --}}

<div class="timesheet-content">

 <?php if($is_project_assigned == 1) {?>
   <nav class = "addProjectNav cf" >
     <ul>
       <li class="myproject cf">
         <a href="#FIXME" title="Add New Entry" class="addProject" id="daily-add" data-toggle="modal" data-target="#create-project">New Entry</a>
       </li>
     </ul>
   </nav>
   <div class="table-timesheet">
     <div class="export-functionality">
       <span>download</span>
       <a href="/excel_timesheet/{{date('Y-m-d', strtotime($date))}}/day/excel" target="_blank" title="Excel"><input type="button" value="Excel" id="export_excel"></a>
       <a href="/excel_timesheet/{{date('Y-m-d', strtotime($date))}}/day/pdf" target="_blank" title="Pdf"><input type="button" value="PDF" id="export_excel"></a>
     </div>
     <table class="day-table">
       <tr class="head-row">
         <th>
           Project Name
         </th>
         <th>
           Hours
         </th>
         <th>
           Edit
         </th>
         <th>
           Delete
         </th>
       </tr>

       @foreach($daily_project as $today_project)
       <tr id="time{{$today_project->id}}">
         <td class="break-words">
          <h3><span class="project_name">{{$today_project->project_name}}</span> - <span class="project_designation">{{$today_project->designation_name}}</span></h3>

          <p><?php echo $today_project->comments; ?></p>

        </td>
        <td>
          {{$today_project->hrs_locked}}
        </td>
        <td>
          <button type="button" class="btn btn-edit edit" title="Edit" id="edit-day-time" data-id= {{$today_project->id}}>Edit User</button>
        </td>
        <td>
          <button type="button" class="btn btn-delete confirm" title="Delete" id="delete-day-time" data-id= "{{$today_project->id}}" data-target="#confirm-delete">Delete User</button>
        </td>
      </tr>
      @endforeach
    </table>
    <div class="time-details">
      <p><span class="tot-hours-title">Total Hours - </span> <span class="tot-hours"></span></p>
      <p><span class="free-time-title">Free Hours - </span> <span class="free-time"></span></p>
    </div>
  </div>
  <?php } else { ?>
    <nav class = "addProjectNav cf" >
     <ul>
       <?php if ($role_id == 1) { ?>
         <li class="myproject cf">
           <a href="#FIXME" title="Add New Project" class="addProject" data-toggle="modal" data-target="#create-new-project">Add New Project</a>
         </li>
         <?php } ?>
         <li class="myproject cf">
           <a href="/myself" title="Add Myself To A Project" class="assign-project">Add myself to a project</a>
         </li>
       </ul>
     </nav>
     <p class="timesheet-message">You are not assigned to any project. Please assign yourself to the project first and start tracking your time.</p>
     <?php } ?>

   </div>
 </div>

 <!-- Add New Project Modal Starts Here-->
 <div class="modal fade create-new-project modal-error-off" id="create-new-project" role="dialog">
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
          <div class="client-type">
            <input type="radio" name="client" id="new" value="new" checked>
            <label for="new">new</label>
            <input type="radio" name="client" id="existing" value="existing">
            <label for="existing">existing</label>
          </div>
          <div class="new-field">
            {!! Form::text('client_name', Input::old('client_name'), array('placeholder' =>'Client name')) !!}
            <p class="error"></p>
          </div>
          <div class="existing-field">
            <select class="existing-client" name="existing_client" id="existing_client">
              <option value="0">Please select client</option>
              @foreach($client_name_list as $value)
              <option value="{{$value}}">{{$value}}</option>
              @endforeach
              <option value="demo">abc</option>
            </select>
            <p class="error"></p>
          </div>
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
        {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
      </div>
    </div>
    <!-- Modal Footer Ends Here -->

  </div>
  <!-- Modal content Starts Here-->

  {!! Form::close() !!}

</div>
</div>
<!-- Add New Project Modal Ends Here-->

{{-- Modal for Delete start here --}}
<div class="modal fade delete-modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
      </div>
      <div class="modal-body">
        <h5>Confirm Delete</h5>
        <p>Remove entry from this timesheet?</p>
        <!-- <p>Are you sure you want to delete?</p>
        <p>Do you want to proceed?</p> -->
        <p class="debug-url"></p>
      </div>

      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
        <a class="btn btn-danger btn-ok" id="btnYes" class="hrs-modified">Delete</a>
      </div>
    </div>
  </div>
</div>
{{-- Modal for delete ends here --}}

<script type="text/javascript">
  $.ajaxSetup({

    headers: {
      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
  });
  $('.date-pick').datepicker( {
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true,
    onSelect: function(date) {
      location.href="../time-management/"+date;
    }
  });
  /****  Check wheather table is empty or not ****/
 var rowCount = $('.day-table tr').length;//if 1 then empty
 if(rowCount<=1)
 {
  var emptyrow='<tr id="empty" class="no-data" align="center"><td  colspan="4">No task to show</td></tr>';
  $('.day-table tr:last').after(emptyrow);
}

$('#daily-add').on({
  focus: function () {
    $(this).blur();
  }
});

$("#project").on('change',function(){
  $('#project_desig').find('option').remove().end();
  var options='<option value="0">Please Select Designation</option><option value="1">PM</option><option value="2">Designer</option><option value="3">FE_Developer</option><option value="4">BE_Developer</option><option value="5">Tester</option><option value="6">Tech Lead</option>';
  $("#project_desig").append(options);

  var project_id=($("#project option:selected").val());

  if(project_id == 'other'){
    location = '/myself';
  }

  var project_name=$("#project option:selected").text();
  $.ajax({
    type:'POST',
    url:'getmyself_project_designation/'+project_id,
    success:function(data){
     if((data).length>0)
     {
       var designation_id=[];
       $.each(data,function( index, value )
       {

         designation_id.push(parseInt(value.designation_id));
       });

       $("#project_desig option").each(function(){

         var value=parseInt($(this).val());
         if($.inArray(value,designation_id)<0)
         {
           if(value>0)
             $("#project_desig option[value='"+value+"']").remove();

         }

       });

       var get_project_designation=[];

       if($(".day-table td").length>1)
       {
        var i=0;
        $(".day-table tr").each(function(){
          if(i>0)
          {
           var option = $(this).find('td:first h3 .project_name').text();

           if(option==project_name)
           {
             get_project_designation.push($(this).find('td:first h3 .project_designation').text());
           }
         }
         i++;
       });

      }

   //   $('#project option[value="'+option+'"]').attr("disabled", true);
 }

 $('#project').prop('disabled', false);





}

});
});
      //$("#project option:option").attr('disabled','disabled')

      /****  Create functionality ****/
      $("#daily-add").on('click',function(e){
        if($('#create-project').hasClass('reset-form')){
          $("#project-day-time")[0].reset();
          $("#project_desig option").remove();
          var options='<option value="0">Please Select Designation</option><option value="1">PM</option><option value="2">Designer</option><option value="3">FE_Developer</option><option value="4">BE_Developer</option><option value="5">Tester</option><option value="6">Tech Lead</option>';
          $("#project_desig").append(options);
          $('#project-day-time select').removeClass('noValue');
        }
        $('#create-project').removeClass('reset-form');
        // $("#project-day-time")[0].reset();
        $('#save').val('Save Entry');
        $("#project_desig").prop('disabled',false);
        $("#project").prop('disabled',false);
        // $('#project-day-time select').removeClass('noValue');
      });

      /********** Add and update functionality************/
      var obj = new phases();
      $(document).on('change','#hrs_locked',function(){
        var getData = $(this).val().trim();
        if(getData.indexOf(":") > -1) {
          var flag = 1 ;
          var separator = getData.split(":"),
          dataBeforeDigit = separator[0], 
          dataAfterDigit = separator[1];
          result = obj.timeConvertion(dataBeforeDigit,dataAfterDigit,flag);
          $('#hidden_Hrs').attr('value',result);
        } else if(getData.indexOf(".") > -1) {
          var flag = 0 ;
          var separator = getData.split(".");
          databeforeColon = separator[0],
          dataAfterColon = separator[1],
          result = obj.timeConvertion(dataAfterColon,databeforeColon,flag);
          $('#hidden_Hrs').attr('value',result);
        } else {
          $('#hidden_Hrs').attr('value',getData);
        }
      });

      $('#project-day-time').on('submit',function(e) {
        e.preventDefault();
        var update_id = $('#row_id').val();
        var formData = $('#project-day-time').serialize();

        var url = $('#project-day-time').attr('action');

        var state = $('#save').val();
        var type = 'post';
        var iserror = 0;
        var project_id=$("#project").val();
        $("#row_id").attr('value',(project_id));
        if (state == 'Update Entry') {
          type = 'put';
          url = url + '/' + update_id+'/'+project_id;
        }

        var prjName = $('#project-day-time #project').val();
        var prjDesig = $('#project_desig').val();
        var hrs = $('#project-day-time #hrs_locked').val().trim();
        var regX = /^[0-9]{0,2}([:.][0-9]{1,2})?$/;

        if(prjName == 0) {
          $('#project-day-time #project').siblings('.error').text('Please select project name');
          $('#project-day-time #project').siblings('.error').show();
        }
        if (prjDesig == 0) {
         $('#project_desig').siblings('.error').text('Please select project designation');
         $('#project-day-time #project_desig').siblings('.error').show();
       }
       if (hrs == '' || Number(hrs) > 16 || hrs == 0) {
        $('#project-day-time #hrs_locked').siblings('.error').text('Please enter hours to complete a task and it should be less than 16');
        $('#project-day-time #hrs_locked').siblings('.error').show();
      }

      if(Number(hrs) < 16 && Number(hrs) > 0 && !hrs.match(regX)) {
       $('#project-day-time #hrs_locked').siblings('.error').text('Please enter numeric values with two decimal place only');
       $('#project-day-time #hrs_locked').siblings('.error').show();
     }

     if(Number(hrs) < 16 && Number(hrs) > 0 && hrs.match(regX)) {
      $('#project-day-time #hrs_locked').siblings('.error').hide();
    }

    var daily_hrs=0;

    if (state == 'Update Entry') {
      var hrs_to_updated=Number($("#time"+update_id).find('td').eq(1).text()); 
      daily_hrs=(Number(daily_hrs)-hrs_to_updated)+Number(hrs);
    }
    else
    {
     $('.day-table').find('tr').not(':first').each(function(key,value)
     {

      var $tds = $(this).find('td');
      daily_hrs = Number(daily_hrs)+Number($tds.eq(1).text());
    });
     daily_hrs=daily_hrs+Number(hrs);
   }

    // if(Number(hrs) < 16 && Number(hrs) > 0 && !hrs.match(regX)){
    //   $('#project-day-time #hrs_locked').siblings('.error').text('maximum decimal places allowed are 2 only');
    //   $('#project-day-time #hrs_locked').siblings('.error').show();
    // }

    // if(Number(hrs) < 16 && Number(hrs) > 0 && !hrs.match(regX)){
    //   $('#project-day-time #hrs_locked').siblings('.error').text('maximum decimal places allowed are 2 only');
    //   $('#project-day-time #hrs_locked').siblings('.error').show();
    // }

    if(daily_hrs>16)
    {
      $('#project-day-time #hrs_locked').siblings('.error').text('Total daily hrs should be less than 16');
      $('#project-day-time #hrs_locked').siblings('.error').show();
    }


    $(".error").each(function(){
      if ($(this).text().trim().length) {
       iserror++;
     }
   });

    if(iserror > 0){
     e.preventDefault();
   }
   else{

    var project_id=$("#project").val();
    $.ajax({
      type: type,
      url: url,
      _METHOD:type,
      data: formData,
      headers:{'project_id':project_id},
      dataType: "json",
      success: function(data) {
        var hidden_hrs = $('#hidden_Hrs').val();
        if(hidden_hrs.indexOf('.') <= -1){
          hidden_hrs = hidden_hrs+".00";
        }

        // var total_hrs=$('#hidden_Hrs').val().toString().replace(/\./g, ':');
        var total_hrs=hidden_hrs.toString().replace(/\./g, ':');

        if($('#empty').length)
        {
          $("#empty").remove();
        }
        if (state == 'Save Entry') {
          if(data.success==2)
          {
            alert("Please check your system date and try again.")
          }
          else
          {
           for (var i = 0; i < data.project_name.length; i++) {
            project_name = data.project_name[i].project_name;
            hrs_locked = data.project_name[i].hrs_locked;
            comments = data.project_name[i].comments;
            var cmnt_replace = comments.replace(/\</g, '&lt;');
            var cmnt_replace1 = cmnt_replace.replace(/\>/g, '&gt;');
            var cmnt_replace1=cmnt_replace.replace(/(?:\r\n|\r|\n)/g, '<br />');
            p_id = data.project_name[i].id;
            d_name=data.project_name[i].d_name;
          }
          var row = '<tr id="time' + p_id + '">'+
          '<td class="break-words">'+ '<h3><span class="project_name">' + project_name + '</span> - <span class="project_designation">'+d_name+'</span></h3>' +
          '<p>' + cmnt_replace1 + '</p>' +'</td>'+
          '<td>' + total_hrs +'</td>'+
          '<td>' + '<button type="button" class="btn btn-edit edit" title="Edit" id="edit-day-time"data-id="' + p_id + '">Edit User</button>' + '</td>' +
          '<td>' + '<button type="button" class="btn btn-delete confirm" title="Delete" id="delete-day-time"data-id="' + p_id + '">Delete User</button>' + '</td>' +
          '</tr>';
          $('.head-row').eq(0).after(row);
          var hours = dayTotalHrs(2,'.day-table');
          $('.day-table ~ .time-details .tot-hours').text(hours['total_hrs']);
          $('.day-table ~ .time-details .free-time').text(hours['free_time']);
        }
      }
      else {
        $('#project-day-time #project_desig[disabled]').siblings('.error').text('');
        var comment_text = data.comments;
        var cmnt_replace = comment_text.replace(/\</g, '&lt;');
        var cmnt_replace1 = cmnt_replace.replace(/\>/g, '&gt;');        
        var cmnt_replace1=cmnt_replace.replace(/(?:\r\n|\r|\n)/g, '<br />');
        var row1 = '<tr id="time' + data.id + '">'+
        '<td class="break-words">'+ '<h3><span class="project_name">' + data.project_name + '</span> - <span class="project_designation">'+data.designation_name+'</span></h3>' +
        '<p>' + cmnt_replace1 + '</p>' +'</td>'+
        '<td>' + total_hrs +'</td>'+
        '<td>' + '<button type="button" class="btn btn-edit edit" title="Edit" id="edit-day-time"data-id="' + data.id + '">Edit User</button>' + '</td>' +
        '<td>' + '<button type="button" class="btn btn-delete confirm" title="Delete" id="delete-day-time"data-id="' + data.id + '">Delete User</button>' + '</td>' +
        '</tr>';
        $('#time' + data.id).replaceWith(row1);
        var hours = dayTotalHrs(2,'.day-table');
        $('.day-table ~ .time-details .tot-hours').text(hours['total_hrs']);
        $('.day-table ~ .time-details .free-time').text(hours['free_time']);
      }
    }
  });
    $("#project-day-time")[0].reset();
    $('#project-day-time select').removeClass('noValue');
    $("#project_desig option").remove();
    var options='<option value="0">Please Select Designation</option><option value="1">PM</option><option value="2">Designer</option><option value="3">FE_Developer</option><option value="4">BE_Developer</option><option value="5">Tester</option><option value="6">Tech Lead</option>';
    $("#project_desig").append(options);
    $('#create-project').modal('hide');
  }
});

/****  Edit functionality ****/
$('tbody').delegate('.btn-edit', 'click', function(){
  var value = $(this).data('id');

  var url = '{{ URL::to('edit-day-project') }}';
  $.ajax({
    type : 'get',
    url : url,
    data : {'id':value},
    headers: {'id': value},
    success : function(data) {
     var total_hrs=(data.hrs_locked).toString().replace(/\./g, ':');

     $('#project_desig')
     .find('option')
     .remove()
     .end();
     $("#project_desig").prop('disabled',true);
     $('#project').prop('disabled', true);
     $('#row_id').val(value);
     $('#project').val(data.project_name);
     var selected_designation="<option value='"+data.d_id+"' disabled>"+data.d_name+"</option>";

     $("#project_desig").append(selected_designation);
     $('#project_desig option[value="'+data.d_id+'"]').attr('selected','selected');
     $('#comments').val(data.comments);
     $('#hrs_locked').val(total_hrs);
     var hid_hrs = total_hrs.replace(/\:/g, '.');
     $('#hidden_Hrs').val(hid_hrs);
     $('#project_id').val(data.id);
     $('#save').val('Update Entry');
     $('#create-project').modal('show');
     $('#create-project').addClass('reset-form');
   }
 });
});

/****  Delete functionality ****/

$('tbody').delegate('.btn-delete', 'click', function(){
  var value = $(this).data('id');
  var url = '{{ URL::to('delete-day-project') }}';
  $("#confirm-delete").modal('show');
  $('#btnYes').click(function() {
    $.ajax({
      type : 'post',
      url : url + '/' + value,
      data : {
        "_token": "{{ csrf_token() }}"
      },
      success : function(data){
        if(data.success==1)
        {
          $('#time' + data.id).remove();
          $("#confirm-delete").modal('hide');

          var hours = dayTotalHrs(2,'.day-table');
          $('.day-table ~ .time-details .tot-hours').text(hours['total_hrs']);
          $('.day-table ~ .time-details .free-time').text(hours['free_time']);

           var rowCount = $('.day-table tr').length;//if 1 then empty

           if(rowCount<=1)
           {
            var emptyrow='<tr id="empty" class="no-data" align="center"><td  colspan="4">No task to show</td></tr>';
            $('.day-table tr:last').after(emptyrow);
          }
        }
      }
    });

  });
});

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
      $('#project_name1').siblings('.error').text('Entered project name already exist');
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
  var iserror = 0;

  if($('#new').is(':checked')){
    $('#existing_client').siblings('.error').text('');
    client_name=$("#client_name").val();
  }else {
    $('#client_name').siblings('.error').text('');
    client_name=$("#existing_client").val();
  }

  var project_status=$(".status_id").val();

  $(".error").each(function(){
    if ($(this).text().trim().length) {
     iserror++;
   }
 });
  console.log('iserror', iserror);

  if(iserror > 0 || client_name == 0){
   e.preventDefault();
 }
 else{
  $.ajax({
    type:'post',
    url:'/project_info',
    data:{'project_name':project_name,'project_code':project_code,'client_name':client_name,'status_id':project_status},
    success:function(data)
    { 
      if(data.duplicate_project_status==1){
        $('#project_name1').siblings('.error').text('Entered project name already exist');
        $('#project_name1').siblings('.error').show();
      }
      else {
        location.href='/store_project';
      }
    }
  });
}
});

</script>
</div>
@stop
