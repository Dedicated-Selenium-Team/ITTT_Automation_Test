	<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<?php
echo "Hi $pm_data[pm_name],
				<p>You are listed in ITTT as the Project Manager for the following projects:</p>
				<p>It’s expected that you will review the below in detail and:<br>
					a) Ensure that it matches up with your understanding of what these individuals are working on.<br>
					b) Escalate and attend to any !Alerts below.<br></p>";
					echo "<p>TODAY’S DATE: ".date('Y/m/d')."<br>
					This email was sent at: ".date('H:i:s')."</p>";
					foreach($pm_data as $key=>$value)
					{
						
						if($key=='pm_name' || $key=='pm_email')
						{	
						}
						else
						{
							echo "Project Name: $key<br>";
							echo "Team-members that logged time today: ";
							if(count($value['users'])>0)
							{
								foreach($value['users'] as $user_key=>$user_value)
								{
									echo "$user_value<br>";
								}
							}
							else
								echo "No Team-members logged time today against this project<br>";

							echo "Total time logged TODAY(all designations): $value[hrs_locked] hours<br>";
							if($value["user_not_filled_timesheet"]>0)
							{
								echo "Time-sheets missing (for today):";
								foreach($value["user_not_filled_timesheet"] as $timesheet_value)
									echo "$timesheet_value<br>";	
							} 
							echo "Estimated hours (all designations):​ $value[project_estimated_hrs] hours<br>";
							echo "Time tracked to-date (all designations): $value[hrs_locked_to_date] hours<br>";
							echo "Estimated project end-date: $value[project_end_date]<br>";
							echo "<font color='red'>";
							if($value["hrs_difference"]==1)
								echo "!Alert: Time tracked to-date is higher than estimate!<br>";
							if($value["is_expired"]==1)
								echo "!Alert: Estimated project end-date has passed!<br>";

							echo "</font><br><br>";
						}

					}
					echo "Note: Estimated hours represented above do NOT incl. warranty period.";
					echo "</p>";

				
?>
</body>
</html>
