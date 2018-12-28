@extends('layouts.ap')

@section('title', 'Rejected Appointments')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('manageappointments.index') }}">Appointment Requests</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('manageappointments.rejected') }}" class="current">Rejected</a></div>
		{{-- <h1>Visitors</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Rejected Appointment Requests</h5>
					</div>

					<div class="widget-content nopadding">
						@if($appointments->isEmpty())
							<div class="alert alert-warning">No rejected appointment requests found!</div>
						@else
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Sl</th>
									<th>From</th>
									<th>Reason Tag</th>
									<th>Purpose</th>
									<th>Visit Schedule</th>
									<th>Applied At</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@php($count=0)
								@foreach($appointments as $appointment)
								@php($count++)
								<tr>
									<td>{{ $count }}</td>
									<td><a href="{{ route('profiles.show', $appointment->visitor) }}">{{ $appointment->visitor->name }}</a></td>
									<td>{{ $appointment->reason->name }}</td>
									<td>{!! substr(ucfirst(nl2br($appointment->purpose)), 0, 40) !!}</td>
									<td>{{ date('F j, Y', strtotime($appointment->vDate)) }}, {{ $appointment->vTime }}</td>
									<td>{{ date('F j, Y, g:i a', strtotime($appointment->created_at)) }}</td>
									<td>
										@if($appointment->status==0)
										<span class="label label-warning">Pending</span>
										@elseif($appointment->status==1)
										<span class="label label-success">Approved</span>
										@elseif($appointment->status==-1)
										<span class="label label-inverse">Denied</span>
										@endif
									</td>
									<td>
										{{-- <a class="btn btn-inverse btn-mini" title="Email"><i class="fa fa-envelope" aria-hidden="true"></i></a> --}}

										{{-- <button class="btn btn-success btn-mini" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></button> --}}
										<a class="btn btn-success btn-mini" href="{{ route('appointments.show', $appointment->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>

										{{-- <a class="btn btn-info btn-mini tip-left" href="#" {{ $appointment->status==0 ? '' : 'disabled' }}><i class="fa fa-check" aria-hidden="true"></i></a> --}}

										<form action="{{ route('manageappointments.update', $appointment->id) }}" method="POST" class="form-inline tip-bottom">
											{{ csrf_field() }}
											{{ method_field('PUT') }}
											<input type="hidden" name="status" value="1">
											<button type="submit" class="btn btn-info btn-mini" onclick="return confirm('Are you sure?')" {{ $appointment->status==0 ? '' : 'disabled' }}><i class="fa fa-check" aria-hidden="true"></i></button>
										</form>

										<form action="{{ route('manageappointments.update', $appointment->id) }}" method="POST" class="form-inline tip-bottom">
											{{ csrf_field() }}
											{{ method_field('PUT') }}
											<input type="hidden" name="status" value="-1">
											<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?')" {{ $appointment->status==0 ? '' : 'disabled' }}><i class="fa fa-times" aria-hidden="true"></i></button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@endif
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection