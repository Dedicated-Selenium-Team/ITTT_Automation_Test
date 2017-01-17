	<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
ITTT Escalation Report<br><br>
<?php
echo "Today's date:".date('d-m-Y')."<br><br>";
echo "How many users submitted Timesheets:".$escalation_report["timesheet_for_today"]."<br><br>";
echo "How many total users on the platform:".$escalation_report["total_user"]."<br><br>";
echo "How many users submitted Timesheets for 6+ hours:".$escalation_report["efficient_user_count"]."<br><br>";
echo 'How many projects have gone "beyond" their total estimated hours (for all designations) till-date:'.$escalation_report["beyond_estimate"]."<br><br>";

?>
</body>
</html>