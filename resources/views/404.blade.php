<!DOCTYPE html>
<html class="error-page-body-html">
<head>
	<title>Laravel</title>
	<link href="/css/stylesheet.css" rel="stylesheet" />
</head>
<body>
	<div class="container">

		<div class="error_wrapper">
			<span class="title">{{ $status_code }}</span>
			<span class="message">{{$message}}</span>
			<a href="http://ittt.prdxnstaging2.com/">Go To Home</a>
		</div>
	</div>
</body>
</html>
