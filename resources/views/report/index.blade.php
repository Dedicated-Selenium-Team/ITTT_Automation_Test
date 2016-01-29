@extends('master')

@section('content')

<div id="tabs_container">
  <ul class = "tabs">
    <li class="active"><a href="#" rel="#tab_1_contents" class="tab tab-log" title="Projects">Projects</a></li>
    <li><a href="#" rel="#tab_2_contents" class="tab de-active" title="Resources">Resources</a></li>
  </ul>
  <div class="tab_contents_container">
    <div class="project-resource-details tab_contents tab_contents_active" id="tab_1_contents">

				<?php
				  foreach ($project_info as $project)
				  {
				    $dev_hours = 0;
				    $qa_hours = 0;
				    $pm_hours = 0;
				    $design_hours = 0;

				    foreach ($user_info as $user)
				    {
				    	if(!empty($users_projects_hours[$user->user_id][$project->project_id]))
				    	{
				    		$resource_hours = 0;
				    		foreach ($users_projects_hours[$user->user_id][$project->project_id] as $user_hours)
					    	{
					    		$resource_hours = $resource_hours + $user_hours;
					    	}
						    if ($user->UserDetails->designation_id == 1)
							  {
							    $dev_hours += $resource_hours;
							  }
							  elseif ($user->UserDetails->designation_id == 2)
							  {
							    $qa_hours += $resource_hours;
							  }
							  elseif ($user->UserDetails->designation_id == 3)
							  {
							    $pm_hours += $resource_hours;
							  }
							  elseif ($user->UserDetails->designation_id == 4)
							  {
							    $design_hours += $resource_hours;
							  }
				    	}
				    }

				    if ($dev_hours && $project->estimated_time)
				    {
				    	$dev_hour_utilization = round((($dev_hours / $project->estimated_time) * 100), 2);
				    }
				    else
				    {
				    	$dev_hour_utilization = 0;
				    }

				    if ($qa_hours && $project->estimated_time)
				    {
				    	$qa_hour_utilization = round((($qa_hours / $project->estimated_time) * 100), 2);
				    }
				    else
				    {
				    	$qa_hour_utilization = 0;
				    }

				    if ($pm_hours && $project->estimated_time)
				    {
				    	$pm_hour_utilization = round((($pm_hours / $project->estimated_time) * 100), 2);
				    }
				    else
				    {
				    	$pm_hour_utilization = 0;
				    }

				    if ($design_hours && $project->estimated_time)
				    {
				    	$design_hour_utilization = round((($design_hours / $project->estimated_time) * 100), 2);
				    }
				    else
				    {
				    	$design_hour_utilization = 0;
				    }

				    echo "<div class='project-wrapper'>
									  <p class='project-name'><span>$project->project_name</span></p>
									  <div class='project-details'>
									    <div class='hours-utilization-bar'>
				  						  <span class='dev' style='width:" . $dev_hour_utilization . "%'></span>
				  							<span class='qa' style='width:" . $qa_hour_utilization . "%'></span>
				  							<span class='pm' style='width:" . $pm_hour_utilization . "%'></span>
				  							<span class='design' style='width:" . $design_hour_utilization . "%'></span>
											</div>
									    <div class='project-hours-details'>
												<p>Hours utilized by Developer: <span>$dev_hour_utilization%</span></p>
												<p>Hours utilized by QA: <span>$qa_hour_utilization%</span></p>
												<p>Hours utilized by PM: <span>$pm_hour_utilization%</span></p>
												<p>Hours utilized by Design team: <span>$design_hour_utilization%</span></p>
												<p>Total Project Estimation: <span>$project->estimated_time</span></p>
											</div>
									  </div>
									</div>";
				  }
				?>

    </div>
    <div class="resource-project-details" id="tab_2_contents">
      <?php
				foreach($user_info as $user)
				{
				  echo "<div class='resource-wrapper'>
				  	<p class='resource-name'><span>$user->first_name $user->last_name</span></p>
				  	<div class='resource-project-wrapper'>";
							foreach($project_info as $project)
							{
								$individual_resource_hours = 0;
							  if(!empty($users_projects_hours[$user->user_id][$project->project_id]))
							  {
				    		  foreach($users_projects_hours[$user->user_id][$project->project_id] as $user_hours)
				    		  {
					    	  	$individual_resource_hours = $individual_resource_hours + $user_hours;
				    		  }
					    	}
							  if ($individual_resource_hours)
							  {
							  	foreach($project['ProjectResources'] as $data)
							  	{
							  		if($data['user_id'] == $user->user_id)
								  	{
								  		$allocate_hours = $data['hours'];
								  	}
							  	}
							  	// $individual_hours_utilization = round((($individual_resource_hours / $project->estimated_time) * 100), 2);
							  	$individual_hours_utilization = round((($individual_resource_hours / $allocate_hours) * 100), 2);
								  echo "<div class='resource-project'>
										<p class='resource-project-name'>$project->project_name</p>
										<div class='hours-utilization-bar'>
				  					  <span class='resource' style='width:" . $individual_hours_utilization . "%'></span>
										</div>
										<p class='resource-project-hours'>Hours utilized: $individual_hours_utilization%</p>
										<p class='allocated-hours'>Allocated hours: $allocate_hours</p>";
									  // <p class='project-actual-hours'>Total Project estimate: $project->estimated_time</p>
									echo "</div>";
								}
							}
				  	echo "</div>
				  </div>";
				}
			?>
    </div>
  </div>
</div>

@stop
