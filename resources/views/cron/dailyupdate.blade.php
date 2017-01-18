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
if(count($user_data['todays_activity'])>0)
{
	echo "<br><br>
Activities logged in ITTT: Today's Date: ".date('d-m-Y').".<br><br>
Time-sheet last saved on: $user_data[last_updated]<br><br>

​Total hours tracked today: $user_data[total_hrs_today] hours (out of 8.5 hours)";
foreach ($user_data['todays_activity'] as $key => $value) {

echo "<p>PROJECT NAME:​ $value[project_name]<br>
My designation:​ $value[designation]<br>
Estimated hours for my designation:​ $value[total_estimated_hrs] hours​<br>
<b>Time tracked today</b>: $value[hrs_locked] hours<br>
<b>Today's task description</b>:<span style='display:block;margin-left:15px;'>$value[description]</span>
Time tracked to-date: $value[total_hrs_to_date] hours<br></p>";

}
}
}
?>
</body>
</html>