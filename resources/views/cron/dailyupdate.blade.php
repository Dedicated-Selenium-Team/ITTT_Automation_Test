	<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
Hi all,
<p>Today, I have made progress on the following activities:
<?php
echo "<br>";
foreach($user_timesheet as $key=>$value)
{
	$tmp=$key+1;
	echo $tmp.". Wroked on $value[description] [$value[hrs_locked]hrs] [$value[project_name]]<br>";
}
?></p>
Tomorrow, I will be continuing After discussing with my team.
</body>
</html>