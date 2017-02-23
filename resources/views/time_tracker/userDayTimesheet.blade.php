@extends('master')
<title>ITTT | Timesheet</title>

@section('content')

<div class="bread-crumb">
  <?php if($unique_project_id != 0) { ?>
    <a href="/store_project">Project</a>
    <a href="/project-designation/{{$unique_project_id}}">Project Designation</a>
    <a class="current-page">Timesheet</a>
    <?php } else { ?>
      <a href="/admin">Users</a>
      <a class="current-page">Timesheet</a>
      <?php } ?>
    </div>


    <div class="day-timesheet">

      <div class="container-heading cf">
        <?php
        $week_date = date('Y, F j', strtotime('monday this week'));
        $today     = date('Y-m-d');
        $prev_date = date('Y-m-d', strtotime($date.' -1 day'));
        $next_date = date('Y-m-d', strtotime($date.' +1 day'));
        ?>
        {!! Form::hidden('', $id, array('id' => 'user_id')) !!}

        <input type="hidden" name="date" value="{{date('l, F j, Y', strtotime($date))}}" class="border-style input-read-only" disabled="true">
        <span class="border-style input-read-only">{{date('l, F j, Y', strtotime($date))}}</span>

        <div class="timesheet-header-right">
          <a href="/time-management/{{$today}}/{{$id}}/{{$unique_project_id}}" class="today"  title="Today">Today</a>

          <div class="arrow">
           <a href="/time-management/{{$prev_date}}/{{$id}}/{{$unique_project_id}}" class="previous" title="Previous">Previous</a>
           <a href="/time-management/{{$next_date}}/{{$id}}/{{$unique_project_id}}" class="next" title="Next">Next</a>
         </div>

         <input class="date-pick" placeholder="DD/MM/YYYY" readonly="readonly" name="joining_date" type="text" value="" id="joining_date" title="Datepicker">

         <div class="views">
           <a href="/time-management/{{$today}}/{{$id}}/{{$unique_project_id}}" title="Day View" class="day active-view">Day</a>
           <a href="/time-management/week/<?=$week_date;?>/{{$id}}/{{$unique_project_id}}" title="Week View" class="week">Week</a>
           <div class="display">
            {!! Form::hidden('hidden_id',$unique_project_id,array('id' => 'Unique_pro_id') ) !!}
          </div>
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
           {!! Form::textarea('comments', '', array('class' => 'comment', 'size' => '26x5', 'placeholder' => 'Enter Task For The Day')) !!}
           <p class="error"></p>
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
           {!! Form::submit('Submit', array('id'=>'save')) !!}
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
         <!--<a href="#FIXME" title="Add New Entry" class="addProject" id="daily-add" data-toggle="modal" data-target="#create-project">New Entry</a>-->
       </li>
     </ul>
   </nav>
   <div class="table-timesheet">
     <span class="user-name">{{$userFullName}} Timesheet</span>
     <div class="export-functionality">
       <span>download</span>
       <div class="export-links"> 
         <a href="/excel_timesheet/{{date('Y-m-d', strtotime($date))}}/day/excel/{{$id}}" target="_blank"><input type="button" value="Excel" id="export_excel"></a>
         <a href="/excel_timesheet/{{date('Y-m-d', strtotime($date))}}/day/pdf/{{$id}}" target="_blank"><input type="button" value="PDF" id="export_excel"></a>
       </div>
     </div>
     <table class="day-table">
       <thead>
         <tr class="head-row">
           <th>
             Project Name
           </th>
           <th>
             Hours
           </th>
       <!--<th>
         Edit
       </th>
       <th>
         Delete
       </th>-->
     </tr>
   </thead>
   <tbody>
     @foreach($daily_project as $today_project)
     <tr id="time{{$today_project->id}}">
      <td class="break-words">
        <h3><span class="project_name">{{$today_project->project_name}}</span> - <span class="project_designation">{{$today_project->designation_name}}</span></h3>
        <p><?php echo $today_project->comments;?></p>
      </td>
      <td>
        {{$today_project->hrs_locked}}
      </td>
      <!--<td>
        <button type="button" class="btn btn-edit edit" id="edit-day-time" data-id= {{$today_project->id}}>Edit User</button>
      </td>
      <td>
        <button type="button" class="btn btn-delete confirm" id="delete-day-time" data-id= "{{$today_project->id}}" data-target="#confirm-delete">Delete User</button>
      </td>-->
    </tr>
    @endforeach
  </tbody>
</table>
<div class="time-details">
  <p><span class="tot-hours-title">Total Hours - </span> <span class="tot-hours"></span></p>
  <p><span class="free-time-title">Free Hours - </span> <span class="free-time"></span></p>
</div>
</div>
<?php } else { ?>
 <p class="timesheet-message">You are not assigned to any project. Please assign yourself to the project first and start tracking your time.</p>
 <?php } ?>

</div>
</div>

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
        <a class="btn btn-danger btn-ok" id="btnYes">Delete</a>
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

  var unique_project_id = $("#Unique_pro_id").val();

  $('.date-pick').datepicker( {
    dateFormat: 'yy-mm-dd',
    changeMonth: true,
    changeYear: true,
    onSelect: function(date) {
      var user_id=$("#user_id").val();
      location.href="../../"+date+"/"+user_id+"/"+unique_project_id;
    }
  });
  /****  Check wheather table is empty or not ****/
  var datatable = $('.day-table').DataTable({
   "bSort":false,
   "orderable": false,
   "paging": false,
   "oLanguage": {"sZeroRecords": "No Task To Show", "sEmptyTable": "No Task To Show"},
   dom: 'Bfrtip',
   buttons: [
   {
    extend: 'excelHtml5',
    title: 'Data export'
  },
  {
    extend: 'pdfHtml5',
    title: 'Data exportation'
  },
  
  ]
     // "scrollY": true
   });




 </script>
 @stop
