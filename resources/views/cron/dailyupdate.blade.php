
<?php


	foreach ($manager_data as $manager_key => $manager_value) {

					echo "Hi ".ucwords($manager_key).",<br><br>";
					echo "You are listed in the PRDXN Org Chart as Manager for the following people:<br>";

					foreach($dr_names as $dr_names_key=>$dr_names_value)
					{
						echo ($dr_names_key+1)." ".ucwords($dr_names_value).".<br>";
					}

					echo "<br>It’s expected that you will review the below in detail and:<br>
					a) Ensure that it matches up with your understanding of what these individuals are working on.<br>
					b) Escalate and attend to any Alerts below.<br><br>";
					echo "TODAY’S DATE: ".date('m/d/Y')."<br>
					This email was sent at: ".date('H:i:s')."<br><br>";

					foreach($manager_value as $manager_value_key=>$manager_value_value)
					{
						if($manager_value_key==0)
							echo "***<br>";
						echo "Name: ".$manager_value_value["name"];
						if(count($manager_value_value["todays_activity"])>0)
							echo "<br>Designation:".$manager_value_value["todays_activity"][0]["designation"];
if($manager_value_value["last_updated"]=='Not updated today')
						echo "<br>Most recent timesheet entry: ".$manager_value_value["last_updated"];
else
					echo "<br>Most recent timesheet entry: ".date('m/d/Y',strtotime($manager_value_value["last_updated"]));
						echo "<br>Total hours tracked in today’s time-sheet: $manager_value_value[total_hrs_today] hours (out of 8.5 hours)<br>";

						if(count($manager_value_value["todays_activity"])>0)
						{
							foreach ($manager_value_value["todays_activity"] as $manager_value_value_key => $manager_value_value_value) {
								echo "<br>PROJECT NAME: ".$manager_value_value_value["project_name"]."<br>";
								echo "Time tracked today: $manager_value_value_value[hrs_locked] hours<br>";
if(count($manager_value_value_value['description'])==0)
$manager_value_value_value['description']='Task not specified.';

								echo "Todays task description: <div style='display:inline-block; vertical-align:top'>";
echo $manager_value_value_value['description'];
echo "</div><br>";
								echo "Estimated hours for this designation:​ $manager_value_value_value[total_estimated_hrs] hours<br>";
								echo "Time tracked to-date (individual only): $manager_value_value_value[total_hrs_to_date] hours<br>";
if($manager_value_value_value['project_end_date']=='Not specified')
echo "Estimated project end-date: ".$manager_value_value_value['project_end_date'];
else
	echo "Estimated project end-date:".date('m/d/Y',strtotime($manager_value_value_value['project_end_date']));	
if(floatval($manager_value_value_value['total_estimated_hrs'])>0)
{
								if(floatval($manager_value_value_value['total_hrs_to_date'])>floatval($manager_value_value_value['total_estimated_hrs']))
									echo "<font color='red'>!Alert: Time tracked to-date is higher than estimate!</font>";
}
							}

echo "<br><br>";
						}
						else
						{
							$get_user_id=DB::table('users')->where('username',$manager_value_value["user_email"])->get();

							$count=DB::table('timesheet_not_filled')->where('user_id',$get_user_id[0]->user_id)->select('count')->get();

							echo "<font color='red'>!Alert:Timesheet for today not submitted<br>Timesheet not submitted occured ".$count[0]->count." times!</font>";
						}
						echo "<br>***<br>";

					}
				}
				?>