<?php
  $role_id = Session::get('user')[0]['role_id'];
  $user_id = Session::get('user')[0]['user_id'];
?>

<nav>
	<ul>
	  <?php if($role_id == 1) { ?>
		<li>
			<a href="/user-management">User</a>
		</li>
		<li>
			<a href="/client-management">Client</a>
		</li>
		<li>
			<a href="/project-management">Project</a>
		</li>
		<li>
			<a href="/activity-management">Activity</a>
		</li>
		<?php } if($role_id == 1 || $role_id == 2) { ?>
		<li>
			<a href="/time-management">Timesheet</a>
		</li>
		<li>
			<a href="/my-projects/{{$user_id}}">My Projects</a>
		</li>
		<li>
			<a href="/reports">Reports</a>
		</li>
		<?php } ?>
	</ul>
</nav>
