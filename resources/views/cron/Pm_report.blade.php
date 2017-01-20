	<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
Hi {{$pm_data['pm_name']}},
<p>The following time was logged for projects that you're assigned to as Project Manager.</p>
<p>
<?php
foreach($pm_data as $key=>$value)
{
	
if($key=='pm_name' || $key=='pm_email')
{	
}
else
{
	echo "Project Name: $key<br>";
	echo "Team-members that logged time today against this project: ";
	if(count($value['users'])>0)
	{
		foreach($value['users'] as $user_key=>$user_value)
		{
			echo "$user_value<br>";
		}
	}
	else
		echo "No Team-members logged time today against this project<br>";

echo "Total time logged TODAY ONLY (all designations) for this project (actuals): $value[hrs_locked] hours<br>"; 
echo "Total time logged to-date (all designations) for this project (actuals): $value[hrs_locked_to_date] hours<br>";
echo "Total estimate (all designations) for this project (not incl. warranty): $value[project_estimated_hrs] hours<br><br>";

}
}
?></p>
</body>
</html>
