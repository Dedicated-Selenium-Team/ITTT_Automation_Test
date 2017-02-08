@extends('master')

@section('content')

<?php
  $user_name_array = array();
  $user_project_array = array();
  $user_project_status = array();
  $end_date = '';
?>

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
												<p><span class='orange indicator'></span>Hours utilized by Developer: <span>$dev_hours hours ($dev_hour_utilization%)</span></p>
												<p><span class='pink indicator'></span>Hours utilized by QA: <span>$qa_hours hours ($qa_hour_utilization%)</span></p>
												<p><span class='green indicator'></span>Hours utilized by PM: <span>$pm_hours hours ($pm_hour_utilization%)</span></p>
												<p><span class='yellow indicator'></span>Hours utilized by Design team: <span>$design_hours hours ($design_hour_utilization%)</span></p>
												<p class='estimation'>Total Project Estimation: <span>$project->estimated_time</span></p>
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
					$user_name_array[$user->user_id] = $user->first_name  . " " . $user->last_name;
					$user_project_array[$user->user_id] = array();
				  echo "<div class='resource-wrapper resource-overflow'>
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
							  	$allocate_hours = 0;
							  	foreach($project['ProjectResources'] as $data)
							  	{
							  		if($data['user_id'] == $user->user_id)
								  	{
								  		$allocate_hours = $data['hours'];
								  		$end_date = $data['end_date'];
								  	}
							  	}
							  	if ($user['UserDetails']->designation_id == '1')
							  	{
							  		$completion_status = $project->dev_completion_status;
							  	}
							  	elseif ($user['UserDetails']->designation_id == '2')
							  	{
							  		$completion_status = $project->qa_completion_status;
							  	}
							  	elseif ($user['UserDetails']->designation_id == '3')
							  	{
							  		$completion_status = $project->pm_completion_status;
							  	}
							  	elseif ($user['UserDetails']->designation_id == '4')
							  	{
							  		$completion_status = $project->design_completion_status;
							  	}

							  	$todays_date = date('Y-m-d');
							  	$days_remaining = 0;
							  	$extra_days_required = 0;
							  	$Projected_extra_hours = 0;
							  	$Projected_extra_days = 0;
							  	$projected_completion_date = 0;
							  	if($end_date > $todays_date)
							  	{
							  		$begin = new DateTime($todays_date);
										$end = new DateTime($end_date);

										$interval = DateInterval::createFromDateString('1 day');
										$period = new DatePeriod($begin, $interval, $end);
										foreach ($period as $dt)
										{
											if(date('N', strtotime($dt->format("Y-m-d"))) < 6)
											{
												$days_remaining +=1;
											}
										}
							  	}
							  	else
							  	{
							  		$begin = new DateTime($end_date);
										$end = new DateTime($todays_date);

										$interval = DateInterval::createFromDateString('1 day');
										$period = new DatePeriod($begin, $interval, $end);
										foreach ($period as $dt)
										{
											if(date('N', strtotime($dt->format("Y-m-d"))) < 6)
											{
												$extra_days_required +=1;
											}
										}
							  	}

							  	if($individual_resource_hours && $allocate_hours && $completion_status)
							  	{
							  		$efficiency = ceil(($completion_status / ($individual_resource_hours / $allocate_hours * 100)) * 100);
							  	}
							  	else
							  	{
							  		$efficiency = 0;
							  	}

							  	if(!$days_remaining)
							  	{
							  		$alert = "red";
							  		$Projected_extra_hours = $allocate_hours - ($allocate_hours * $completion_status / 100);
							  		$Projected_extra_days = ceil($Projected_extra_hours / 8);

							  		$start_date = date('Y-m-d');

								    $date = new DateTime($start_date);
								    $time_stamp = $date->getTimestamp();

								    // loop for X days
								    for($i = 0; $i < $Projected_extra_days; $i++)
								    {

								        // add 1 day to timestamp
								        $addDay = 86400;

								        // get what day it is next day
								        $nextDay = date('w', ($time_stamp + $addDay));

								        // if it's Saturday or Sunday get $i-1
								        if($nextDay == 0 || $nextDay == 6) {
								            $i--;
								        }

								        // modify timestamp, add 1 day
								        $time_stamp = $time_stamp + $addDay;
								    }

								    $date->setTimestamp($time_stamp);
									  $projected_completion_date = $date->format('Y-m-d');

							  	}
							  	else
							  	{
							  		$alert = "";
							  		$projected_completion_date = $end_date;
							  	}

								  echo "<div class='resource-project'>
										<p class='resource-project-name'>$project->project_name</p>
										<div class='hours-utilization-bar'>
				  					  <span class='resource' style='width: " . $efficiency . "%'></span>
										</div>
										<p class='resource-project-hours'>Hours utilized: $individual_resource_hours hours</p>
										<p class='allocated-hours'>Allocated hours: $allocate_hours hours</p>
										<p class='" . $alert . "'>Days Remaining: $days_remaining</p>
										<p class='" . $alert . "'>Number of extra days taken: $extra_days_required</p>
										<p>Completion Status: $completion_status%</p>
										<p>Efficiency: $efficiency%</p>
									  <p>Projected Completion Date: $projected_completion_date</p>
									  <p>Projected Extra Days: $Projected_extra_days ($Projected_extra_hours hours)</p>";
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
