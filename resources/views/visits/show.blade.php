@extends('layouts.ap')

@section('title', 'View Visit Request')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visits.index') }}" class="current">My Visit Requests</a></div>
		{{-- <h1>Visitors</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Visit Request</h5>
					</div>

					<div class="widget-content">
						<div class="row-fluid">
							<div class="span6">
								@if(Session::has('visitRequestSent'))
								<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									{{ Session::get('visitRequestSent') }}
								</div>
								@endif
								@if(Session::has('visitUpdateSuccess'))
								<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									{{ Session::get('visitUpdateSuccess') }}
								</div>
								@endif
								<table class="table table-bordered table-invoice">
									<tbody>
										<tr>
											<tr>
												@if(Auth::user()->role=='visitor')
												<td class="width30">To <span class="label">{{ $visit->admin->role }}</span>:</td>
												<td class="width70">
													<strong><a href="{{ route('profiles.show', $visit->adminId) }}">{{ $visit->admin->name }}</a></strong>
													<br>
													<a href="mailto:{{ $visit->admin->email }}">{{ $visit->admin->email }}</a>
												</td>
												@elseif(Auth::user()->role=='admin')
												<td class="width30">From:</td>
												<td class="width70">
													<strong><a href="{{ route('profiles.show', $visit->visitorId) }}">{{ $visit->visitor->name }}</a></strong>
													<br>
													<a href="mailto:{{ $visit->visitor->email }}">{{ $visit->visitor->email }}</a>
												</td>
												@endif
											</tr>
											<tr>
												<td>Visit Schedule:</td>
												<td><strong>{{ date('F j, Y', strtotime($visit->vDate)) }}, {{ $visit->vTime }}</strong></td>
											</tr>
											<tr>
												<td>Applied At:</td>
												<td>
													<strong>{{ date('F j, Y, g:i a', strtotime($visit->created_at)) }}</strong>
												</td>
											</tr>
											<tr>
												<td>Application Status:</td>
												<td>
													@if($visit->status==0)
													<span class="label label-warning">Pending</span>
													@elseif($visit->status==1)
													<span class="label label-success">Approved</span>
													@elseif($visit->status==-1)
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
												<td class="width70">{{ $visit->reason->name }}</td>
											</tr>
											<tr>
												<td>Visiting Purpose(In brief):</td>
												<td>{!! nl2br($visit->purpose) !!}</td>
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
								<button class="btn btn-info btn-mini mailUser" data-toggle="modal" data-target="#mailUser{{ $visit->adminId }}">Email {{ $visit->admin->name }}</button>
								
								<div id="mailUser{{ $visit->adminId }}" class="modal hide" style="text-align: left !important">
									<form action="{{ route('mail.send', $visit->adminId) }}" method="POST">
									{{ csrf_field() }}
									<div class="modal-header">
										<button data-dismiss="modal" class="close" type="button">×</button>
										<h3>Mail To: {{ $visit->admin->name }}</h3>
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

								<a class="btn btn-info btn-mini" href="{{ route('visits.edit', $visit->id) }}" {{ $visit->status==1 || $visit->status==-1 ? 'disabled' : '' }}>Edit Application</a>
								<form action="{{ route('visits.destroy', $visit->id) }}" method="POST" class="form-inline tip-bottom">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
									<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?')" {{ $visit->status==-1 ? 'disabled' : '' }}>Delete</button>
								</form>
								@elseif(Auth::user()->role=='admin')
								<button class="btn btn-info btn-mini mailUser" data-toggle="modal" data-target="#mailUser{{ $visit->visitorId }}">Email {{ $visit->visitor->name }}</button>

								<div id="mailUser{{ $visit->visitorId }}" class="modal hide" style="text-align: left !important">
									<form action="{{ route('mail.send', $visit->visitorId) }}" method="POST">
									{{ csrf_field() }}
									<div class="modal-header">
										<button data-dismiss="modal" class="close" type="button">×</button>
										<h3>Mail To: {{ $visit->visitor->name }}</h3>
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

								<form action="{{ route('managevisits.destroy', $visit->id) }}" method="POST" class="form-inline tip-bottom">
									{{ csrf_field() }}
									{{ method_field('DELETE') }}
									<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?')">Delete</button>
								</form>
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
								<a class="btn btn-success" {{ $visit->status==1 ? '' : 'disabled' }} href="{{ route('visitDownload', $visit->id) }}"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
								@elseif(Auth::user()->role=='admin')
									@if($visit->status==0)
									<form action="{{ route('managevisits.update', $visit->id) }}" method="POST" class="form-inline tip-bottom">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										<input type="hidden" name="status" value="1">
										<button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?')"><i class="fa fa-check" aria-hidden="true"></i> Accept</button>
									</form>
									<form action="{{ route('managevisits.update', $visit->id) }}" method="POST" class="form-inline tip-bottom">
										{{ csrf_field() }}
										{{ method_field('PUT') }}
										<input type="hidden" name="status" value="-1">
										<button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
									</form>
									@elseif($visit->status==1)
									<button class="btn btn-success" disabled><i class="fa fa-check" aria-hidden="true"></i> Accepted</button>
									@elseif($visit->status==-1)
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