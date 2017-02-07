<?php
header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
	<title>ITTT</title>
	<!--<link rel="shortcut icon" href="favicon.ico" />-->
	<!-- Bootstrap CSS -->

	<link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet"/>

	<!-- Jquery UI stylesheet  -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
	<link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
	<!-- ITTT stylesheet  -->
	<link href="{{ asset('css/stylesheet.css') }}" rel="stylesheet" />
	<!-- <link href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" /> -->

	<script src="https://apis.google.com/js/api:client.js"></script>

	<!-- jQuery JS -->
	<script src="{{ asset('vendor/jquery-2.1.1.min.js') }}"></script>

	<!-- Jquery-UI JS -->
	<script src="{{ asset('js/jqueryUI.js') }}"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.13/features/searchHighlight/dataTables.searchHighlight.min.js">
	</script>
	<script type="text/javascript" src="//bartaz.github.io/sandbox.js/jquery.highlight.js">
	</script>
	<link href="//cdn.datatables.net/plug-ins/1.10.13/features/searchHighlight/dataTables.searchHighlight.css" rel="stylesheet" />

	<!-- Current JS -->
	<script src="{{ asset('js/object.js') }}"></script>
	<script src="{{ asset('js/retrive.js') }}"></script>


	<!-- Bootstrap JS -->
	<script type="text/javascript" src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.8.0/fullcalendar.min.js" charset="utf-8"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.8.0/fullcalendar.min.css" charset="utf-8"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.8.0/fullcalendar.print.css" charset="utf-8"></script> -->

<meta name="_token" content="{!!csrf_token()!!}" />
<!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> -->
<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	ga('create', 'UA-88745953-1', 'auto');
	ga('send', 'pageview');

</script>
</head>
<!-- body starts here -->
<body>
	<!-- header start's from here -->
	<header class="cf">
		<div class="wrapper">
			<!-- here we inclueded header srarts here -->
			@include('templates/header')
			<!-- here we inclueded header Ends here -->
		</div>
	</header>
	<!-- header ends here -->

	<!-- Main start's from here -->
	<main>
		<!-- main content starts here -->
		<div class="content">
			<!-- wrapper starts here -->
			<div class="wrapper">

				<?php
				$role_id = Session::get('user')[0]['role_id'];
				if ($role_id) {?>
					<!-- nav border div starts here -->
					<div class="nav-border">
						<!-- nav content div starts here -->
						<div class="nav-content">
							<?php }?>

							<?php if ($role_id == 1 || $role_id == 2) {?>
								@include('templates/menu')
							</div>
							<!-- nav content div ends here -->
						</div>
						<!-- nav borde ends here -->
						<?php }?>
						<div class="content-wrapper">
							<div class="content-inner-wrapper">
								<div class="overlay">
									<div class="session-expired cf">
										<h4>session expired</h4>
										<p>Please re-login to restart your session.</p>
										<a href="/logout">sign in</a>
									</div>
								</div>
								@yield('content')
							</div>
						</div>

					</div>
					<!-- wrapper ends here -->
					<a href="https://groups.google.com/forum/#!forum/ittt-forum" class="scroll" title="ITTT Forum" target="_blank">ITTT Forum</a>
				</div>
				<!-- main Content ends here -->
			</main>
			<!-- Main end's here -->

			<!-- footer starts from here -->
			<footer>

			</footer>
			<!-- footer ends here -->

		</body>
		<!-- body ends here -->

		</html>
