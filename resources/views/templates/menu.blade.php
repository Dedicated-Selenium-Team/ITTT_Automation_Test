<?php
$role_id = Session::get('user')[0]['role_id'];
$user_id = Session::get('user')[0]['user_id'];
?>
<!-- nav starts here -->
<nav class="nav-hamber cf">
	<a href="" title="Menu" class="hamb">
	</a>
	<a href="" title="Close Menu" class="hamb-cross">
	</a>
</nav>
<!-- nav ends here -->

<!-- main menu list starts here -->
<ul class="navigation-menu">
	<?php if ($role_id == 1 || $role_id == 2) {?>
	<!-- <li class="all-projects">
			<a href="/store_project" title="Projects">Projects</a>
		</li> -->
		<!-- <li class="admin-nav"> -->
		<!-- <a href="/admin" title="Admin">
		Admin
	</a> -->
	<!-- <a> Admin </a> -->

	<!-- admin sub menu starts here -->
	<!--  <ul class="sub-admin-nav"> -->

	<li class="time-management time-sheet">
		<?php
		$date = Carbon\Carbon::now()->format('Y-m-d');
		?>
		<a href="/time-management/{{$date}}" title="Timesheet">
			Timesheet
		</a>
	</li>
	<li class="all-projects">
		<a href="/store_project" title="Projects">Projects</a>
	</li>
	<!-- commented for hiding purpose. w'll uncomment after discusing with PM -->
										<!--
								 		<li >
											<a href="/admin/add-details" class="admin-menu setting">SETTING</a>
										</li> -->
										<!-- </ul> -->
										<!-- admin sub menu Ends here -->
										<!-- </li> -->
										<?php }if ($role_id == 1) {?>
											<li>
												<a href="/admin" class="admin-menu user" title="Users">users</a>
											</li>
											<!-- <li class="my-projects my-projects-i">
												<a href="/my-projects/{{$user_id}}" title="My Projects">
													My Projects
												</a>
											</li>-->
											<!-- <li class="desingation project-designation-i">
												<a href="/project-designation " title="Project Designation">
													Project Designation
												</a>
											</li> -->
											<?php }?>
										</ul>
										<!-- main menu ends here -->
