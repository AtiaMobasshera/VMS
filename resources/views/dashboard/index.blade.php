@extends('layouts.ap')

@section('title', 'Dashboard')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom current"><i class="fa fa-home" aria-hidden="true"></i> Home</a></div>
		{{-- <h1>Add Designation</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				@if(Auth::user()->role=='admin')
				<div class="quick-actions_homepage">
					<ul class="quick-actions">
						<li class="bg_lb span3"><a href="{{ route('visitors.index') }}"><i class="fa fa-user fa-2x"></i><br><span class="label label-inverse">{{ $data['visitors'] }}</span>Visitors</a></li>
						<li class="bg_lg span3"><a href="{{ route('hosts.index') }}"><i class="fa fa-user fa-2x"></i><br><span class="label label-inverse">{{ $data['hosts'] }}</span>Hosts</a></li>
					</ul>
				</div>
				<div class="quick-actions_homepage">
					<ul class="quick-actions">
						<li class="bg_ly span2"><a href="{{ route('managevisits.index') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['visitRequests'] }}</span>Visit Requests</a></li>
						<li class="bg_lg span2"><a href="{{ route('managevisits.approved') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['approvedVisitRequests'] }}</span>Approved</a></li>
						<li class="bg_ls span2"><a href="{{ route('managevisits.pending') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['pendingVisitRequests'] }}</span>Pending</a></li>
						<li class="bg_lo span2"><a href="{{ route('managevisits.rejected') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['rejectedVisitRequests'] }}</span>Rejected</a></li>
					</ul>
				</div>
				@endif

				@if(Auth::user()->role=='visitor')
				<div class="quick-actions_homepage">
					<ul class="quick-actions">
						<li class="bg_ly span2"><a href="{{ route('visits.index') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['visitRequests'] }}</span>Visit Requests</a></li>
						<li class="bg_lg span2"><a href="{{ route('visits.approved') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['approvedVisitRequests'] }}</span>Approved</a></li>
						<li class="bg_ls span2"><a href="{{ route('visits.pending') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['pendingVisitRequests'] }}</span>Pending</a></li>
						<li class="bg_lo span2"><a href="{{ route('visits.rejected') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['rejectedVisitRequests'] }}</span>Rejected</a></li>
					</ul>
				</div>
				<div class="quick-actions_homepage">
					<ul class="quick-actions">
						<li class="bg_lo span3"><a href="{{ route('appointments.index') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['appointmentRequests'] }}</span>Appointment Requests</a></li>
						<li class="bg_lg span2"><a href="{{ route('appointments.approved') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['approvedAppointmentRequests'] }}</span>Approved</a></li>
						<li class="bg_ly span2"><a href="{{ route('appointments.pending') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['pendingAppointmentRequests'] }}</span>Pending</a></li>
						<li class="bg_ls span2"><a href="{{ route('appointments.rejected') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['rejectedAppointmentRequests'] }}</span>Rejected</a></li>
					</ul>
				</div>
				@endif
				
				@if(Auth::user()->role=='host')
				<div class="quick-actions_homepage">
					<ul class="quick-actions">
						<li class="bg_lo span3"><a href="{{ route('manageappointments.index') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['appointmentRequests'] }}</span>Appointment Requests</a></li>
						<li class="bg_lg span2"><a href="{{ route('manageappointments.approved') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['approvedAppointmentRequests'] }}</span>Approved</a></li>
						<li class="bg_ly span2"><a href="{{ route('manageappointments.pending') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['pendingAppointmentRequests'] }}</span>Pending</a></li>
						<li class="bg_ls span2"><a href="{{ route('manageappointments.rejected') }}"><i class="fa fa-server fa-2x"></i><br><span class="label label-inverse">{{ $data['rejectedAppointmentRequests'] }}</span>Rejected</a></li>
					</ul>
				</div>
				@endif

				@if(Auth::user()->role=='admin' || Auth::user()->role=='receptionist')
				<div class="quick-actions_homepage">
					<br>
					<ul class="quick-actions">
						<li class="bg_lr span2"><a href="{{ route('visitReports.today') }}"><i class="fa fa-superpowers fa-2x"></i><br><span class="label label-inverse">{{ $data['visitedToday'] }}</span>Visited Today</a></li>
						<li class="bg_lg span3"><a href="{{ route('appointmentReports.today') }}"><i class="fa fa-superpowers fa-2x"></i><br><span class="label label-inverse">{{ $data['appointmentToday'] }}</span>Appointment Today</a></li>
					</ul>
				</div>
				@endif

			</div>
		</div>
	</div>
</div>

@endsection