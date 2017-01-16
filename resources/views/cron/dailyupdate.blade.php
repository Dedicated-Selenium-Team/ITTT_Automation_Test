	<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
Hi All,
<?php
if(count($activity)>0)
{
if(count($activity['todays_activity'])>0)
{
	echo "<p>Today, I have made progress on the following activities:
<br>";
foreach($activity['todays_activity'] as $key=>$value)
{

	$tmp=$key+1;
	echo $tmp.".$value[project_name] - $value[description] [$value[hrs_locked]]<br>";
}
}
else
	echo "<p>Today, no activities were performed.";
}
?></p>
<?php
if(count($activity['tomorrows_activity'])>0)
{
	echo "<p>Tomorrow, I will be continuing with the following activities:<br>";
	foreach($activity['tomorrows_activity'] as $key=>$value)
	{
		$tmp=$key+1;
		echo $tmp."$value[project_name] - $value[description] [$value[hrs_locked]]<br>";
	}
}
?>
</p>
</body>
</html>