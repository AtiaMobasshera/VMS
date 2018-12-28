<!DOCTYPE html>
<html lang="en">
<head>
	{{-- Meta --}}
	<meta charset="UTF-8">
	
	{{-- Title --}}
	<title>Visiting Card</title>

	{{-- CSS --}}
	<link rel="stylesheet" href="css/ap/bootstrap.min.css">
	<link rel="stylesheet" href="css/ap/bootstrap-responsive.min.css">
	{{-- <link rel="stylesheet" href="css/ap/vms-ap.css"> --}}

	{{-- JS --}}
	<script src="js/ap/jquery.min.js"></script>
	<script src="js/ap/jquery.ui.custom.js"></script>
	<script src="js/ap/bootstrap.min.js"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="text-center">
			<h2>Visitor Management System ( VMS )</h2>
		</div>
		<br><br>
		<div class="row-fluid">
			<div class="span4">
				<img src="images/avatar/{{ $visit->visitor->profile->avatar }}" alt="" style="width: 150px; height: 150px">
			</div>
			<div class="span8">
				<p>Name:  {{ $visit->visitor->name }}</p>
				<p>Email:  {{ $visit->visitor->email }}</p>
				<p>Phone:  {{ $visit->visitor->profile->phone }}</p>
				<p>Address:  {{ $visit->visitor->profile->address }}</p>
				<p>Purpose:  Visit</p>
				<p>Applied At:  {{ date('F j, Y, g:i a', strtotime($visit->created_at)) }}</p>
				<p>Visiting Time:  {{ date('F j, Y', strtotime($visit->vDate)) }}, {{ $visit->vTime }}</p>
				<br>
				<p>Access Code:  <b><span style="color: darkblue">{{ $visit->code }}</span></b></p>
			</div>
		</div>
	</div>
</body>
</html>