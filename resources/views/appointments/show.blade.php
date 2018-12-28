@extends('layouts.ap')

@section('title', 'View Appointment Request')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('appointments.index') }}" class="current">My Appointment Requests</a></div>
		{{-- <h1>Visitors</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Appointment Request</h5>
					</div>

					<div class="widget-content">
						<div class="row-fluid">
							<div class="span6">
								@if(Session::has('appointmentRequestSent'))
								<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									{{ Session::get('appointmentRequestSent') }}
								</div>
								@endif
								@if(Session::has('appointmentUpdateSuccess'))
								<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									{{ Session::get('appointmentUpdateSuccess') }}
								</div>
								@endif
								<table class="table table-bordered table-invoice">
									<tbody>
										<tr>
											<tr>
												@if(Auth::user()->role=='visitor')
												<td class="width30">To <span class="label">{{ $appointment->host->role }}</span>:</td>
												<td class="width70">
													<strong><a href="{{ route('profiles.show', $appointment->hostId) }}">{{ $appointment->host->name }}</a></strong>
													<br>
													<i class="fa fa-star" aria-hidden="true"></i> {{ ucwords($appointment->host->hostDesignation->designation->name) }}
													<br>
													<a href="mailto:{{ $appointment->host->email }}">{{ $appointment->host->email }}</a>
												</td>
												@elseif(Auth::user()->role=='host')
												<td class="width30">From:</td>
												<td class="width70">
													<strong><a href="{{ route('profiles.show', $appointment->visitorId) }}">{{ $appointment->visitor->name }}</a></strong>
													<br>
													<a href="mailto:{{ $appointment->visitor->email }}">{{ $appointment->visitor->email }}</a>
												</td>
												@endif
											</tr>
											<tr>
												<td>Visit Schedule:</td>
												<td><strong>{{ date('F j, Y', strtotime($appointment->vDate)) }}, {{ $appointment->vTime }}</strong></td>
											</tr>
											<tr>
												<td>Applied At:</td>
												<td>
													<strong>{{ date('F j, Y, g:i a', strtotime($appointment->created_at)) }}</strong>
												</td>
											</tr>
											<tr>
												<td>Application Status:</td>
												<td>
													@if($appointment->status==0)
													<span class="label label-warning">Pending</span>
													@elseif($appointment->status==1)
													<span class="label label-success">Approved</span>
													@elseif($appointment->status==-1)
													<span class="label label-inverse">Denied</span>
													@endif
												</td>
											</tr>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="span6">
								<table class="table table-bordered table-invoice">
									<tbody>
										<tr>
											<tr>
												<td class="width30">Visiting Reason Title</td>
												<td class="width70">{{ $appointment->reason->name }}</td>
											</tr>
											<tr>
												<td>Visiting Purpose(In brief):</td>
												<td>{!! nl2br($appointment->purpose) !!}</td>
											</tr>
										</tr>
									</tbody>
								</table>

								@if($errors->has('subject') || $errors->has('body'))
								<script>
									$(document).ready(function(){
										$($('.mailUser').data('target')).modal('show');
									});
								</script>
								@endif
								
								@if(Auth::user()->role=='visitor')
								<button class="btn btn-info btn-mini mailUser" data-toggle="modal" data-target="#mailUser{{ $appointment->hostId }}">Email {{ $appointment->host->name }}</button>

								<div id="mailUser{{ $appointment->hostId }}" class="modal hide" style="text-align: left !important">
									<form action="{{ route('mail.send', $appointment->hostId) }}" method="POST">
									{{ csrf_field() }}
									<div class="modal-header">
										<button data-dismiss="modal" class="close" type="button">×</button>
										<h3>Mail To: {{ $appointment->host->name }}</h3>
									</div>
									<div class="modal-body">
										<div class="control-group">
											<label class="control-label">Subject :</label>
											<div class="controls">
												<input type="text" class="span12" name="subject" placeholder="Mail Subject" required>
												@if($errors->has('subject'))
												<li class="error">{{ $errors->first('subject') }}</li>
												@endif
												<span class="help-block">At least 5 words</span>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label">Body :</label>
											<div class="controls">
												<textarea name="body" class="span12" cols="30" rows="6" placeholder="Write here" required></textarea>
												@if($errors->has('body'))
												<li class="error">{{ $errors->first('body') }}</li>
												@endif
												<span class="help-block">At least 15 words</span>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Send</button>
										<button data-dismiss="modal" class="btn">Cancel</button>
									</div>
									</form>
								</div>

								<a class="btn btn-info btn-mini" href="{{ route('appointments.edit', $appointment->id) }}" {{ $appointment->status==1 || $appointment->status==-1 ? 'disabled' : '' }}>Edit Application</a>
								<form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" class="form-inline tip-bottom">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
									<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?')" {{ $appointment->status==-1 ? 'disabled' : '' }}>Delete</button>
								</form>
								@elseif(Auth::user()->role=='host')
								<button class="btn btn-info btn-mini mailUser" data-toggle="modal" data-target="#mailUser{{ $appointment->visitorId }}">Email {{ $appointment->visitor->name }}</button>
								
								<div id="mailUser{{ $appointment->visitorId }}" class="modal hide" style="text-align: left !important">
									<form action="{{ route('mail.send', $appointment->visitorId) }}" method="POST">
									{{ csrf_field() }}
									<div class="modal-header">
										<button data-dismiss="modal" class="close" type="button">×</button>
										<h3>Mail To: {{ $appointment->visitor->name }}</h3>
									</div>
									<div class="modal-body">
										<div class="control-group">
											<label class="control-label">Subject :</label>
											<div class="controls">
												<input type="text" class="span12" name="subject" placeholder="Mail Subject" required>
												@if($errors->has('subject'))
												<li class="error">{{ $errors->first('subject') }}</li>
												@endif
												<span class="help-block">At least 5 words</span>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label">Body :</label>
											<div class="controls">
												<textarea name="body" class="span12" cols="30" rows="6" placeholder="Write here" required></textarea>
												@if($errors->has('body'))
												<li class="error">{{ $errors->first('body') }}</li>
												@endif
												<span class="help-block">At least 15 words</span>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Send</button>
										<button data-dismiss="modal" class="btn">Cancel</button>
									</div>
									</form>
								</div>
								@endif
								<br><br>
							</div>
						</div>

						@if(Session::has('mailSent'))
						<div class="row-fluid">
							<div class="span12">
								<div class="alert alert-success">{!! Session::get('mailSent') !!}</div>
							</div>
						</div>
						@endif

						<div class="row-fluid">
							<div class="span12">
								@if(Auth::user()->role=='visitor')
								<a class="btn btn-success" {{ $appointment->status==1 ? '' : 'disabled' }} href="{{ route('appointmentDownload', $appointment->id) }}"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
								@elseif(Auth::user()->role=='host')
									@if($appointment->status==0)
									<form action="{{ route('manageappointments.update', $appointment->id) }}" method="POST" class="form-inline tip-bottom">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										<input type="hidden" name="status" value="1">
										<button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?')"><i class="fa fa-check" aria-hidden="true"></i> Accept</button>
									</form>
									<form action="{{ route('manageappointments.update', $appointment->id) }}" method="POST" class="form-inline tip-bottom">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										<input type="hidden" name="status" value="-1">
										<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
									</form>
									@elseif($appointment->status==1)
									<button class="btn btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i> Accepted</button>
									@elseif($appointment->status==-1)
									<button class="btn btn-danger" disabled><i class="fa fa-times" aria-hidden="true"></i> Rejected</button>
									@endif
								@endif
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection