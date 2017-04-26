<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tasky</title>
    <link rel="stylesheet" href="{{ URL::to('css/main.css') }}">
    <link rel="stylesheet" href="{{ URL::to('css/app.css') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	@include('partials.header')

	<div class="container main">
		@if (session('message'))
		<div class="alert alert-danger alert-dismissable fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		  	<strong>Access Denied!</strong> {{ session('message') }}
		</div>
		@endif

	    @yield('content')
	</div>
</body>
</html>