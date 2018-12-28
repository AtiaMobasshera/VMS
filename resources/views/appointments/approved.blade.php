@extends('layouts.ap')

@section('title', 'Appointment Requests')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('appointments.index') }}">My Appointment Requests</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('appointments.approved') }}" class="current">Approved</a></div>
		{{-- <h1>Visitors</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Appointment Requests</h5>
					</div>

					<div class="widget-content nopadding">
						@if($appointments->isEmpty())
							<div class="alert alert-warning">No appointment requests approved!</div>
						@else
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Sl</th>
									<th>To</th>
									<th>Reason Tag</th>
									<th>Purpose</th>
									<th>Appointment Schedule</th>
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
									<td><a href="{{ route('profiles.show', $appointment->hostId) }}">{{ $appointment->host->name }} ( {{ $appointment->host->hostDesignation->designation->name }} )</a></td>
									<td>{{ $appointment->reason->name }}</td>
									<td>{!! substr(ucfirst(nl2br($appointment->purpose)), 0, 20) !!}</td>
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

										{{-- <a class="btn btn-info btn-mini tip-left" href="{{ route('appointments.edit', $appointment->id) }}" {{ $appointment->status==1 || $appointment->status==-1 ? 'disabled' : '' }}><i class="fa fa-pencil" aria-hidden="true"></i></a> --}}
										<a class="btn btn-info btn-mini" href="{{ route('appointmentDownload', $appointment->id) }}"><i class="fa fa-download" aria-hidden="true"></i></a>

										<form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="form-inline tip-bottom">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
											<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?')" {{ $appointment->status==-1 ? 'disabled' : '' }}><i class="fa fa-trash" aria-hidden="true"></i></button>
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