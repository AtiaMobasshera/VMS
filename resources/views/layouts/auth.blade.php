<!DOCTYPE html>
<html lang="en">
<head>
	{{-- Meta --}}
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="E Reception, Visitor Management System, VMS, Visitor Entry">
	
	{{-- Title --}}
	<title>ER | @yield('title')</title>

	{{-- CSS --}}
	<link rel="stylesheet" href="{{ asset('css/auth/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/auth/font-awesome.css') }}">
	<link rel="stylesheet" href="{{ asset('css/auth/vms-auth.css') }}">

	{{-- JS --}}
	<script src="{{ asset('js/auth/jquery.min.js') }}"></script>
	<script src="{{ asset('js/auth/bootstrap.min.js') }}"></script>
</head>
<body>
	@yield('body')
</body>
</html>
