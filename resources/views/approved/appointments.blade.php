<!DOCTYPE html>
<html lang="en">
<head>
	{{-- Meta --}}
	<meta charset="UTF-8">
	
	{{-- Title --}}
	<title>Appointment Card</title>

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
				<img src="images/avatar/{{ $appointment->visitor->profile->avatar }}" alt="" style="width: 150px; height: 150px">
			</div>
			<div class="span8">
				<p>Name:  {{ $appointment->visitor->name }}</p>
				<p>Email:  {{ $appointment->visitor->email }}</p>
				<p>Phone:  {{ $appointment->visitor->profile->phone }}</p>
				<p>Address:  {{ $appointment->visitor->profile->address }}</p>
				<p>Purpose:  Visit</p>
				<p>Host:  <b>{{ $appointment->host->name }}</b></p>
				<p>Applied At:  {{ date('F j, Y, g:i a', strtotime($appointment->created_at)) }}</p>
				<p>Visiting Time:  {{ date('F j, Y', strtotime($appointment->vDate)) }}, {{ $appointment->vTime }}</p>
				<br>
				<p>Access Code:  <b><span style="color: darkblue">{{ $appointment->code }}</span></b></p>
			</div>
		</div>
	</div>
</body>
</html>