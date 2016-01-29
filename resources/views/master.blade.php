<html>
	<head>
		<title>ITTT</title>
		<link href="/css/style.css" rel="stylesheet" />
	</head>
	<body>
		<div class="wrapper">
		<header class="cf">
			@include('templates/header')
		</header>
		<div class="content">
			  @yield('content')
		</div>
		<footer>
			@include('templates/footer')
		</footer>
		<script src="/vendor/jquery-2.1.1.min.js"></script>
		<script src="/js/script.js"></script>
		</div>
	</body>
</html>
