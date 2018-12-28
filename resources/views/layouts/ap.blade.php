<!DOCTYPE html>
<html lang="en">
<head>
	{{-- Meta --}}
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="Visitor Management System, VMS, Visitor Entry">
	
	{{-- Title --}}
	<title>@yield('title')</title>

	{{-- CSS --}}
	<link rel="stylesheet" href="{{ asset('css/ap/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/ap/bootstrap-responsive.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/ap/vms-ap.css') }}">
	<link rel="stylesheet" href="{{ asset('css/ap/vms-ap-media.css') }}">
	<link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.css') }}">
	@yield('css')
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,800" type="text/css">

	{{-- JS --}}
	<script src="{{ asset('js/ap/jquery.min.js') }}"></script>
	<script src="{{ asset('js/ap/jquery.ui.custom.js') }}"></script>
	<script src="{{ asset('js/ap/bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/ap/jquery.dataTables.min.js') }}"></script>
	@yield('topJs')
</head>
<body>
	{{-- Header Title --}}
	<div id="header">
		<h3><a href="{{ route('home') }}"><i class="fa fa-ravelry" aria-hidden="true"></i> ER</a></h3>
	</div>

	{{-- Top Header --}}
	@include('partials._apTopHeader')

	{{-- Side Nav --}}
	@include('partials._apSideNav')
	
	{{-- Body --}}
	@yield('body')

	{{-- Footer --}}
	<div class="row-fluid">
		<div id="footer" class="span12">&copy; 2017 ER. All Rights Reserved | Developed by Anonymous</div>
	</div>
	
	{{-- JS --}}
	<script src="{{ asset('js/ap/vms.js') }}"></script>
	<script src="{{ asset('js/ap/vms.tables.js') }}"></script>
	@yield('bottomJs')
</body>
</html>