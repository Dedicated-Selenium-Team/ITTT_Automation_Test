@extends('master')
<title>ITTT | Projects</title>

@section('content')

<!-- <div class="bread-crumb">
  <div> 
    <a class="current-page">projects</a>
  </div>
</div> -->

<!-- All Projects Container data starts here -->
<div class="wrap-content cf">

  <!-- Add New Project Button Starts Here  -->
  <nav class = "addProjectNav container-heading cf" >
    <ul>
      <?php
      $role_id = Session::get('user')[0]['role_id'];
      if ($role_id == 1) {?>
        <li class="myproject cf">
         <a href="#FIXME" title="Add New Project" class="addProject" data-toggle="modal" data-target="#create-project">Add New Project</a>
       </li>
       <?php }if ($role_id == 1 || $role_id == 2) {?>
         <li>
           <a href="/myself" title="Add Myself To A Project" class="assign-project">Add myself to a project</a>
         </li>
         <?php }?>
       </ul>
     </nav>
     <!-- Add New Project Button Ends Here  -->

     <!-- Add New Project Modal Starts Here-->
     <div class="modal fade create-new-project modal-error-off" id="create-project" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content Starts Here-->
        <div class="modal-content">

          <!-- Modal Header Starts Here -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h1 class="modal-title">Create New Project</h1>
          </div>
          <!-- Modal Header Ends Here -->

          <!-- Modal Body Starts Here -->
          <div class="modal-body">

            {!! Form::open(array('id' => 'add-project', 'method' => 'post')) !!}

            <div class="form-group cf">
              {!! Html::decode(Form::label('project_name','Project Name<span class="required">*</span>:')) !!}
              {!! Form::text('project_name', Input::old('project_name'), array('class' => '','placeholder' =>'Project name')) !!}
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

    <!-- Edit Project Modal starts Here-->
    <div class="modal fade modal-error-off edit-project" id="edit-project" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content Starts Here-->
        <div class="modal-content">

          <!-- Modal Header Starts Here -->
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h1 class="modal-title">Edit Project</h1>
          </div>
          <!-- Modal Header Ends Here -->

          <!-- Modal Body Starts Here -->
          <div class="modal-body">

            {!! Form::open(array('id' => 'edit-project-data', 'method' => 'post')) !!}

            {!! Form::hidden('project_id', '',array('id'=>'edit_project_id'))!!}

            <div class="form-group cf">
              {!! Html::decode(Form::label('edit_project_name','Project Name<span class="required">*</span>:')) !!}
              {!! Form::text('edit_project_name','', array('class' => '','placeholder' =>'Project name')) !!}
              <p class="error"></p>
            </div>

            <div class="form-group cf">
              {!! Html::decode(Form::label('edit_client_name','Client Name<span class="required">*</span>:')) !!}
              {!! Form::text('edit_client_name','', array('placeholder' =>'Client name')) !!}
              <p class="error"></p>
            </div>

          </div>
          <!-- Modal Body Ends Here -->

          <!-- Modal Footer Starts Here -->
          <div class="modal-footer">
            <div class="save-project">
              {!! Form::submit('Update')!!}
              {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
            </div>
          </div>
          <!-- Modal Footer Ends Here -->

        </div>
        <!-- Modal content Starts Here-->

        {!! Form::close() !!}

      </div>
    </div>
    <!-- Edit Project Modal Ends Here-->

    <!-- All Projects list starts here -->
    <?php $count = count($myproject)+count($projects);
    ?>
    <div class="timesheet-content all-projects-content">
      <div class="total-projects cf">
        <h2 class="project-count">Total Number of Projects: <span class="italic">{{ $count }}</span> </h2>
        <h2 class="project-count">total Number of Projects assigned: <span class="italic">{{ count($myproject) }}</span> </h2>
        <!--<input type='text' id='search_project' class="form-control search-function project-search" placeholder="Search Project">-->
      </div>

      <div class="all-prj connectedSortable" id="tabs">
        <ul>
          <li><a href="#tabs-1">All Projects</a></li>
          <li><a href="#tabs-2">Estimates</a></li>
          <li><a href="#tabs-3">Live-Projects</a></li>
          <li><a href="#tabs-4">Live-Ongoing</a></li>
          <li><a href="#tabs-5">Completed</a></li>
        </ul>
        <div id="tabs-1" class="grid">
          <?php if((count($projects) == 0)) {?>
            <p class="noproject-message">There are no projects to show.</p>
            <?php }
            ?>

            @foreach( $myproject as $my_allproject  )
            <div class="wrap-project assigned-projects cf">

              <?php if ($role_id == 1) {?>
                <div class="actions cf">

                  <!--<span>Action</span> -->
                  <div>
                   <select id="project_action" class="edit-action-arrow">
                     <option value = "1">Please Select</option>
                     <option value="2_{{$my_allproject->project_id }}" data-toggle="modal" class="edit-action" data-id="{{$my_allproject->project_id}}">Edit</option>
                     <option value="3_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Delete</option>
                     <option value="4_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Archive</option>
                   </select>
                 </div>
               </div>
               <?php } ?>
               <a href="/project-designation/{{$my_allproject->project_id}}" class="count_name">
                <!-- <div class="all-project-details"> -->
                <span class="pro_name" title="Project Name: {{ $my_allproject->project_name }}">{{ $my_allproject->project_name }}</span>
                <span class="pro_client" title="Client Name: {{ $my_allproject->client_name }}">{{ $my_allproject->client_name }}</span>
                <span class="pro_code" title="Project ID: {{ $my_allproject->project_id }}">ID: {{ $my_allproject->project_id }}</span>
                <span class="pro_desig" title="Designation: {{ $my_allproject->designation_name }}">{{ $my_allproject->designation_name }}</span>
                <!-- </div> -->
              </a>
              <div class="estimate-plan">
                <span class="estimate-span">
                  <?php if($my_allproject->estimation_status == 0) { ?>
                    <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan not-filled">Estimation</a>
                    <?php } else { ?>
                      <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan">Estimation</a>
                      <?php }?>

                    </span>
                    <span class="planning-span">
                      <?php if($my_allproject->planning_status == 0) { ?>
                        <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan not-filled">Planning</a>
                        <?php } else { ?>
                          <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan">Planning</a>
                          <?php }?>
                        </span>
                      </div>
                    </div>

                    @endforeach

                    @foreach( $projects as $project_detail )

                    <div class="wrap-project unassigned-projects cf">
                      <?php if ($role_id == 1) {
                        ?>
                        <div class="actions cf">
                          <!--<span>Action</span> -->
                          <div>
                            <select id="project_action" class="edit-action-arrow">
                              <option value = "1">Please Select</option>
                              <option value="2_{{$project_detail->project_id }}" data-toggle="modal" class="edit-action" data-id="{{$project_detail->project_id}}">Edit</option>
                              <option value="3_{{$project_detail->project_id }}" data-id="{{$project_detail->project_id}}">Delete</option>
                              <option value="4_{{$project_detail->project_id }}" data-id="{{$project_detail->project_id}}">Archive</option>
                            </select>
                          </div>
                        </div>
                        <?php }?>
                        <a href="/project-designation/{{$project_detail->project_id}}" class="count_name">
                          <!-- <div class="all-project-details"> -->
                          <span class="pro_name" title="Project Name: {{ $project_detail->project_name }}">{{ $project_detail->project_name }}</span>
                          <span class="pro_client" title="Client Name: {{ $project_detail->client_name }}">{{ $project_detail->client_name }}</span>
                          <span class="pro_code" title="Project ID: {{ $project_detail->project_id }}">ID: {{ $project_detail->project_id }}</span>
                          <!-- </div> -->
                        </a>
                        <div class="estimate-plan">
                          <span class="estimate-span">
                           <?php if($project_detail->estimation_status == 0) { ?>
                             <a href="/store_project/estimate/{{ $project_detail->project_id }}" title="Estimation" class="detail-plan not-filled">Estimation</a>
                             <?php } else { ?>
                               <a href="/store_project/estimate/{{ $project_detail->project_id }}" title="Estimation" class="detail-plan">Estimation</a>
                               <?php } ?>
                             </span>
                             <span class="planning-span">
                              <?php if($project_detail->planning_status == 0) { ?>
                                <a href="/store_project/planning/{{ $project_detail->project_id }}" title="Planning" class="detail-plan not-filled">Planning</a>
                                <?php } else { ?>
                                  <a href="/store_project/planning/{{ $project_detail->project_id }}" title="Planning" class="detail-plan">Planning</a>
                                  <?php } ?>
                                </span>
                              </div>
                            </div>
                            @endforeach

                          </div>

                          <div id="tabs-2">
                            <?php if(count($estimates_project) == 0) {?>
                              <p class="noproject-message">There are no projects to show.</p>
                              <?php } ?>

                              @foreach($estimates_project as $my_allproject  )
                              @if($my_allproject->is_myproject == "Yes")
                              <div class="wrap-project assigned-projects cf">
                               @else
                               <div class="wrap-project cf">
                                @endif

                                <?php if ($role_id == 1) {?>
                                  <div class="actions cf">
                                    <!--<span>Action</span> -->
                                    <div>
                                      <select id="project_action" class="edit-action-arrow">
                                        <option value = "1">Please Select</option>
                                        <option value="2_{{$my_allproject->project_id }}" data-toggle="modal" class="edit-action" data-id="{{$my_allproject->project_id}}">Edit</option>
                                        <option value="3_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Delete</option>
                                        <option value="4_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Archive</option>
                                      </select>
                                      <select name="ddlProjectStatus" id="pStatus" class="proj_status" title="Move To">
                                        <option value="1">Please Select</option>
                                        <option value="2_{{$my_allproject->project_id }}">Live-Projects</option>
                                        <option value="3_{{$my_allproject->project_id }}">Live-Ongoing</option>
                                        <option value="4_{{$my_allproject->project_id }}">Completed</option>
                                      </select>
                                    </div>
                                  </div>
                                  <?php } ?>
                                  <a href="/project-designation/{{$my_allproject->project_id}}" class="count_name">
                                    <!-- <div class="all-project-details"> -->
                                    <span class="pro_name" title="Project Name: {{ $my_allproject->project_name }}">{{ $my_allproject->project_name }}</span>
                                    <span class="pro_client" title="Client Name: {{ $my_allproject->client_name }}">{{ $my_allproject->client_name }}</span>
                                    <span class="pro_code" title="Project ID: {{ $my_allproject->project_id }}">ID: {{ $my_allproject->project_id }}</span>
                                    <span class="pro_desig" title="Designation: {{ $my_allproject->designation_name }}">{{ $my_allproject->designation_name }}</span>
                                    <!-- </div> -->
                                  </a>

                                  <div class="estimate-plan">
                                    <span class="estimate-span">
                                      <?php if($my_allproject->estimation_status == 0) { ?>
                                        <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan not-filled">Estimation</a>
                                        <?php } else { ?>
                                          <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan">Estimation</a>
                                          <?php } ?>
                                        </span>
                                        <span class="planning-span">
                                          <?php if($my_allproject->planning_status == 0) { ?>
                                            <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan not-filled">Planning</a>
                                            <?php } else { ?>
                                              <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan">Planning</a>
                                              <?php } ?>
                                            </span>
                                          </div>
                                        </div>
                                        @endforeach
                                      </div>
                                      <div id="tabs-3">

                                       <?php if(count($live_project) == 0) {?>
                                         <p class="noproject-message">There are no projects to show.</p>
                                         <?php } ?>

                                         @foreach( $live_project as $my_allproject  )
                                         @if($my_allproject->is_myproject == "Yes")
                                         <div class="wrap-project assigned-projects cf">
                                           @else
                                           <div class="wrap-project cf">
                                            @endif

                                            <?php if ($role_id == 1) {?>
                                              <div class="actions cf">
                                                <!--<span>Action</span> -->
                                                <div>
                                                  <select id="project_action" class="edit-action-arrow">
                                                    <option value = "1">Please Select</option>
                                                    <option value="2_{{$my_allproject->project_id }}" data-toggle="modal" class="edit-action" data-id="{{$my_allproject->project_id}}">Edit</option>
                                                    <option value="3_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Delete</option>
                                                    <option value="4_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Archive</option>
                                                  </select>
                                                  <select name="ddlProjectStatus" id="pStatus" class="proj_status" title="Move To">
                                                    <option value="1">Please Select</option>
                                                    <option value="3_{{$my_allproject->project_id }}">Live-Ongoing</option>
                                                    <option value="4_{{$my_allproject->project_id }}">Completed</option>
                                                  </select>
                                                </div>
                                              </div>
                                              <?php } ?>
                                              <a href="/project-designation/{{$my_allproject->project_id}}" class="count_name">
                                                <!-- <div class="all-project-details"> -->
                                                <span class="pro_name" title="Project Name: {{ $my_allproject->project_name }}">{{ $my_allproject->project_name }}</span>
                                                <span class="pro_client" title="Client Name: {{ $my_allproject->client_name }}">{{ $my_allproject->client_name }}</span>
                                                <span class="pro_code" title="Project ID: {{ $my_allproject->project_id }}">ID: {{ $my_allproject->project_id }}</span>
                                                <span class="pro_desig" title="Designation: {{ $my_allproject->designation_name }}">{{ $my_allproject->designation_name }}</span>
                                                <!-- </div> -->
                                              </a>

                                              <div class="estimate-plan">
                                                <span class="estimate-span">
                                                 <?php if($my_allproject->estimation_status == 0) { ?>
                                                   <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan not-filled">Estimation</a>
                                                   <?php } else { ?>
                                                     <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan">Estimation</a>
                                                     <?php } ?>
                                                   </span>
                                                   <span class="planning-span">
                                                    <?php if($my_allproject->planning_status == 0) { ?>
                                                      <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan not-filled">Planning</a>
                                                      <?php } else { ?>
                                                        <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan">Planning</a>
                                                        <?php } ?>
                                                      </span>
                                                    </div>
                                                  </div>
                                                  @endforeach

                                                </div>
                                                <div id="tabs-4">
                                                  <?php if(count($live_ongoing_project) == 0) {?>
                                                    <p class="noproject-message">There are no projects to show.</p>
                                                    <?php } ?>
                                                    @foreach($live_ongoing_project as $my_allproject  )
                                                    @if($my_allproject->is_myproject == "Yes")
                                                    <div class="wrap-project assigned-projects cf">
                                                     @else
                                                     <div class="wrap-project cf">
                                                      @endif

                                                      <?php if ($role_id == 1) {?>
                                                        <div class="actions cf">
                                                          <!--<span>Action</span> -->
                                                          <div>
                                                            <select id="project_action" class="edit-action-arrow">
                                                              <option value = "1">Please Select</option>
                                                              <option value="2_{{$my_allproject->project_id }}" data-toggle="modal" class="edit-action" data-id="{{$my_allproject->project_id}}">Edit</option>
                                                              <option value="3_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Delete</option>
                                                              <option value="4_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Archive</option>
                                                            </select>
                                                            <select name="ddlProjectStatus" id="pStatus" class="proj_status" title="Move To">
                                                              <option value="1">Please Select</option>
                                                              <option value="4_{{$my_allproject->project_id }}">Completed</option>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <?php } ?>
                                                        <a href="/project-designation/{{$my_allproject->project_id}}" class="count_name">
                                                          <!-- <div class="all-project-details"> -->
                                                          <span class="pro_name" title="Project Name: {{ $my_allproject->project_name }}">{{ $my_allproject->project_name }}</span>
                                                          <span class="pro_client" title="Client Name: {{ $my_allproject->client_name }}">{{ $my_allproject->client_name }}</span>
                                                          <span class="pro_code" title="Project ID: {{ $my_allproject->project_id }}">ID: {{ $my_allproject->project_id }}</span>
                                                          <span class="pro_desig" title="Designation: {{ $my_allproject->designation_name }}">{{ $my_allproject->designation_name }}</span>
                                                          <!-- </div> -->
                                                        </a>

                                                        <div class="estimate-plan">
                                                          <span class="estimate-span">
                                                            <?php if($my_allproject->estimation_status == 0) { ?>
                                                              <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan not-filled">Estimation</a>
                                                              <?php } else { ?>
                                                                <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan">Estimation</a>
                                                                <?php } ?>
                                                              </span>
                                                              <span class="planning-span">
                                                                <?php if($my_allproject->planning_status == 0) { ?>
                                                                  <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan not-filled">Planning</a>
                                                                  <?php } else { ?>
                                                                    <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan">Planning</a>
                                                                    <?php } ?>
                                                                  </span>
                                                                </div>
                                                              </div>
                                                              @endforeach
                                                            </div>
                                                            <div id="tabs-5">
                                                              <?php if(count($completed_project) == 0) {?>
                                                                <p class="noproject-message">There are no projects to show.</p>
                                                                <?php } ?>
                                                                @foreach( $completed_project as $my_allproject  )
                                                                @if($my_allproject->is_myproject == "Yes")
                                                                <div class="wrap-project assigned-projects cf">
                                                                 @else
                                                                 <div class="wrap-project cf">
                                                                  @endif

                                                                  <?php if ($role_id == 1) {?>
                                                                    <div class="actions cf">
                                                                      <!--<span>Action</span> -->
                                                                      <div>
                                                                       <select id="project_action" class="edit-action-arrow">
                                                                        <option value = "1">Please Select</option>
                                                                        <option value="2_{{$my_allproject->project_id }}" data-toggle="modal" class="edit-action" data-id="{{$my_allproject->project_id}}">Edit</option>
                                                                        <option value="3_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Delete</option>
                                                                        <option value="4_{{$my_allproject->project_id }}" data-id="{{$my_allproject->project_id}}">Archive</option>
                                                                      </select>
                                                                    </div>
                                                                  </div>
                                                                  <?php } ?>
                                                                  <a href="/project-designation/{{$my_allproject->project_id}}" class="count_name">
                                                                    <!-- <div class="all-project-details"> -->
                                                                    <span class="pro_name" title="Project Name: {{ $my_allproject->project_name }}">{{ $my_allproject->project_name }}</span>
                                                                    <span class="pro_client" title="Client Name: {{ $my_allproject->client_name }}">{{ $my_allproject->client_name }}</span>
                                                                    <span class="pro_code" title="Project ID: {{ $my_allproject->project_id }}">ID: {{ $my_allproject->project_id }}</span>
                                                                    <span class="pro_desig" title="Designation: {{ $my_allproject->designation_name }}">{{ $my_allproject->designation_name }}</span>
                                                                    <!-- </div> -->
                                                                  </a>
                                                                  <div class="estimate-plan">
                                                                    <span class="estimate-span">
                                                                     <?php if($my_allproject->estimation_status == 0) { ?>
                                                                       <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan not-filled">Estimation</a>
                                                                       <?php } else { ?>
                                                                         <a href="/store_project/estimate/{{ $my_allproject->project_id }}" title="Estimation" class="detail-plan">Estimation</a>
                                                                         <?php } ?>
                                                                       </span>
                                                                       <span class="planning-span">
                                                                        <?php if($my_allproject->planning_status == 0) { ?>
                                                                          <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan not-filled">Planning</a>
                                                                          <?php } else { ?>
                                                                            <a href="/store_project/planning/{{ $my_allproject->project_id }}" title="Planning" class="detail-plan">Planning</a>
                                                                            <?php } ?>
                                                                          </span>
                                                                        </div>
                                                                      </div>
                                                                      @endforeach
                                                                    </div>

                                                                  </div>
                                                                </div>
                                                                <!-- All Projects list ends here -->
                                                                <!-- Modal for Delete start here -->
                                                                <div class="modal fade delete-modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                  <div class="modal-dialog modal-sm">
                                                                    <div class="modal-content">
                                                                      <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                        <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                                                                      </div>
                                                                      <div class="modal-body">
                                                                        <h5>Confirm Delete</h5>
                                                                        <p>Are you sure you want to remove this Project?</p>
                                                                        <p class="debug-url"></p>
                                                                      </div>
                                                                      <div class="modal-footer">
                                                                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
                                                                        <a class="btn btn-danger btn-ok" id="btnYes">Delete</a>
                                                                      </div>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <!-- Modal for delete ends here -->

                                                              <!-- Modal for Archive Delete start here -->
                                                              <div class="modal fade delete-modal" id="archive-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm">
                                                                  <div class="modal-content">
                                                                    <div class="modal-header">
                                                                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                      <h4 class="modal-title" id="myModalLabel">Confirm Archive</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                      <h5>Confirm Archive</h5>
                                                                      <p>Are you sure you want to archive this Project?</p>
                                                                      <p class="debug-url"></p>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                      <a class="btn btn-danger btn-ok" id="btnYes">Archive</a>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                              <!-- Modal for Archiver delete ends here -->
                                                              <script>
                                                               $.ajaxSetup({

                                                                headers: {
                                                                  'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                                                }
                                                              });

                                                               $(window).load(function() {
                                                                 var grid = $('.grid').isotope({});
                                                                 $("#search_project").keyup(function(){
                                                                  var searchstring=$("#search_project").val().toUpperCase();
                                                                  var divtosearch=$(".wrap-project");
                                                                  grid.isotope({
                                                                    filter: function( divtosearch ) {
                                                                      return ($(".pro_name",this).html().indexOf(searchstring)>-1)
                                                                    }
                                                                  });
                                                                });
                                                               });

                                                               $(".proj_status").change(function(){
                                                                var status=($(this).val()).split("_");
                                                                var project_status=status[0];
                                                                var project_id=status[1];
                                                                if(project_status==1)
                                                                  alert("please select project status");
                                                                else
                                                                {
                                                                  $.ajax({
                                                                   type: 'POST',
                                                                   url: 'change_project_status',
                                                                   data: {'project_id':project_id,'project_status':project_status},
                                                                   success:function(data)
                                                                   {
                                                                    if(data.success==1){
                                                                      location.reload();
                            // $("#tabs").tabs({ active: project_status });
                          }
                          else{
                            alert("Something went wrong.Please try again later.");
                          }
                        }

                      });
                                                                }

                                                              });


                //  $(".addProject").on('click',function(e){
                //   $("#add-project")[0].reset();
                //   $('.save-project input[type="submit"]').val('Submit');
                //   $('#project-day-time select').removeClass('noValue');
                // });

                $('#edit-project').on('submit',function(e) {
                  e.preventDefault();
                  var project_id=$("#edit_project_id").val();
                  var project_name=$("#edit_project_name").val();
                  var client_name=$("#edit_client_name").val();
                  $.ajax({
                    type:'get',
                    url:'edit_project_info',
                    data:{'project_id':project_id,'project_name':project_name,'client_name':client_name},
                    success:function(data)
                    { 
                      location.reload();
                    }
                  });
                });

                /****  Edit functionality ****/
                $(document).on('click','.plan',function() {
                  $('.planing').fadeIn();
                  $('.plan').css('color','#3b5998');
                  $('.est').css('color','#000');
                  $('.estimate').fadeOut();
                });

                $(document).on("change", '#project_action', function (e) {
                  e.preventDefault();
                  var status=($(this).val()).split("_"),
                  getProjectValue=status[0],
                  project_id=status[1];
                  console.log('project_id', project_id);

                  if (getProjectValue === '2') {
                    $('#edit-project').modal('show');
                    var value = project_id;
                    var url = 'edit-project';
                    $.ajax({
                      type : 'get',
                      url : url,
                      data : {'id':value},
                      headers: {'id': value},
                      success : function(data) {
                        $('#edit_project_name').val(data.project_name);
                        $('#edit_client_name').val(data.client_name);
                        $('#edit_project_id').val(data.project_id);
                        $('#edit-project').modal('show');
                      }
                    });
                  } 

                  if (getProjectValue === '3') {
                    $('#confirm-delete').modal('show');
                    $('#confirm-delete .btn-ok').attr('data-id' , project_id);
                  }
                  if (getProjectValue === '4') {
                    $('#archive-delete').modal('show');
                    $('#archive-delete .btn-ok').attr('data-id' , project_id);
                  }
                  $(this).prop('selectedIndex',0);
                });

                $('#confirm-delete').delegate('#btnYes', 'click', function(e){
                  var value = $(this).attr("data-id");
                  e.preventDefault();
                  $('#confirm-delete').modal('hide');
                  url = 'delete-project/'+value;
                  $.ajax({
                    type : 'post',
                    url : url,
                    data : {'id':value},
                    headers: {'id': value},
                    success : function(data) {
                      console.log('data', data);
                      location.reload();
                    }
                  });
                });

                $('#archive-delete').delegate('#btnYes', 'click', function(e){
                  e.preventDefault();
                  var value = $(this).attr("data-id");
                  $('#archive-delete').modal('hide');
                  url = 'archive-project/'+value;
                  console.log("url",url);
                  $.ajax({
                    type : 'post',
                    url : url,
                    data : {'id':value},
                    headers: {'id': value},
                    success : function(data) {
                      console.log('data', data);
                      location.reload();
                    }
                  });
                });


              </script>
            </div>
            @stop
