	<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
ITTT Escalation Report<br><br>
<?php
echo "Today's date: ".date('d-m-Y')."<br><br>";
echo "Total timesheets submitted, today: ".$escalation_report["timesheet_for_today"]."<br><br>";
echo "How many total users on the platform: ".$escalation_report["total_user"]."<br><br>";
echo "How many users submitted Timesheets for 6+ hours: ".$escalation_report["efficient_user_count"]."<br><br>";
echo 'Number of projects whereby actuals have exceeded the estimate: '.$escalation_report["beyond_estimate"]."<br>";
if($escalation_report["beyond_estimate"]>0)
{
	echo "Project names:<span style='display:block;margin-left:15px;'>";
	foreach($escalation_report["beyond_estimate_project_list"] as $key=>$value)
	{
		$numbering=$key+1;
 	echo "$numbering. $value<br>";
	}
	echo "</span><br><br>";
}

echo "Who did NOT submit a Timesheet:<span style='display:block;margin-left:15px;'>";
 foreach($escalation_report['timesheet_not_submitted'] as $key=>$value)
 {
 	$numbering=$key+1;
 	echo "$numbering. $value->first_name $value->last_name<br>";
 }
echo "</span><b>Total: ".count($escalation_report['timesheet_not_submitted'])."<b>";


?>
</body>
</html>