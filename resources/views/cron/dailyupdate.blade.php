	<!DOCTYPE html>
	<html>
	<head>
		<title></title>
	</head>
	<body>
		Hi All,
		<?php
		
		if(count($user_data)>0)
		{
	foreach($user_data as $key=>$value)
	{
		if(count($value)==0)
			echo "No timesheet";
		else
		{
			if(count($value['todays_activity'])>0)
			{
				echo "<br><br>
				Activities logged in ITTT: Today's Date: ".date('d-m-Y')."<br><br>
				Time-sheet last saved on: $value[last_updated]<br><br>

				​Total hours tracked today: $value[total_hrs_today] hours (out of 8.5 hours)";
				foreach ($value['todays_activity'] as $todays_activity_key => $todays_activity_value) {

					echo "<p>PROJECT NAME:​ $todays_activity_value[project_name]<br>
					My designation:​ $todays_activity_value[designation]<br>
					Estimated hours for my designation:​ $todays_activity_value[total_estimated_hrs] hours​<br>
					<b>Time tracked today</b>: $todays_activity_value[hrs_locked] hours<br>
					<b>Today's task description</b>:";
					if(strlen($todays_activity_value['description'])>1)
					{
						echo "<span style='display:block;margin-left:15px;'>$todays_activity_value[description]</span>";
					}
					else
					{
						echo "<span style='display:block;margin-left:15px;'>Task not described</span>";
					}
					echo "Time tracked to-date: $todays_activity_value[total_hrs_to_date] hours<br></p>";

				}
			}
		}
		}
		}
		?>
	</body>
	</html>