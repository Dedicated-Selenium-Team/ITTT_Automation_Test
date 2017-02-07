<!-- main row starts here -->
<div class="header-content cf">
	<!-- logo div starts here -->
	<div class="logo">
		<h1>
			<a href="/" title="PRDXN">PRDXN</a>
		</h1>
	</div>
	<!-- logo div ends here -->

	<!-- profile content starts here  -->
	<div class="profile-content">
		<?php
		$role_id = Session::get('user')[0]['role_id'];
		if ($role_id) {?>
			<!-- user-name content div starts here -->
			<div class="user-name">
				<span class="fname">{{ Session::get('user')[0]['first_name'] }}</span>
				<span class="lname">{{ Session::get('user')[0]['last_name'] }}</span>
			</div>
			<!-- user-name content div ends here -->
			<!-- log-out content div starts here -->
			<div class="log-out">
				<a href="{{URL::to('logout')}}" title="Sign Out" class="logout">Sign Out</a>
			</div>
			<!-- log-out content div Ends here -->
			<?php }
// $user_name = Session::get('user')[0]['user_name'];
// echo $user_name;
			?>
		</div>
		<!-- profile content ends her -->
	</div>
<!-- main row ends here
