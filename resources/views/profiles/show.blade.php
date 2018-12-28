@extends('layouts.ap')

@section('title', $user->name)

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('profiles.index') }}" class="tip-bottom">Profiles</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('profiles.show', $user->id) }}" class="current">{{ $user->name }}</a></div>
		{{-- <h1>Add Designation</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="fa fa-user-circle-o" aria-hidden="true"></i> </span>
						<h5>User Profile</h5>
					</div>
					<div class="widget-content">
						<div class="row-fluid">
							<div class="span4">
								{{-- @if(isset($user->hostDesignation))
								{{ $user->hostDesignation->designation->name }}
								@endif --}}
								<br><br>
								@if(!isset($profile))
									<div class="avatar">
										<img src="{{ asset('images/avatar/noimage.png') }}" class="img-polaroid" width="170px" height="170px" alt="">
									</div>
								@else
									<div class="avatar">
										<img src="{{ asset('images/avatar/'.$profile->avatar) }}" class="img-polaroid" width="170px" height="170px" alt="">
									</div>
								@endif
								<h4>{{ $user->name }}</h4>

								@if($user->role=='host')
								<span><i class="fa fa-star"></i> {{ ucwords($user->hostDesignation->designation->name) }}</span>
								<br><br>
								@endif
								<span class="label">{{ ucwords($user->role) }}</span>

								@if(Auth::user()->id==$user->id)
								<p>{{ $user->email }}</p>
								@else
								<br>
								<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
								@endif
							</div>

							<div class="span8">
								<div class="profile-action text-right">
								@if(Auth::user()->id==$user->id)
									<a class="btn btn-success btn-mini" href="{{ route('profiles.edit', Auth::user()->id) }}">Edit Profile</a>
								@endif
								@if(Auth::user()->role=='admin' && Auth::user()->id!=$user->id)
									<a class="btn btn-danger btn-mini" href="#">Remove User</a>
								@endif
								</div>
								<br>

								<table class="table table-bordered table-invoice">
									<tbody>
										<tr>
											<tr>
												<td class="width30">Name:</td>
												<td class="width70"><strong>{{ $user->name }}</strong></td>
											</tr>
											<tr>
												<td>Email:</td>
												<td>
													<strong>{{ $user->email }}</strong>
													@if(Auth::user()->id!=$user->id)
													<button class="btn btn-info btn-mini mailUser" style="float: right" data-toggle="modal" data-target="#mailUser{{ $user->id }}"><i class="fa fa-envelope"></i></button>
													@endif
												</td>
											</tr>
											<tr>
												<td>Phone:</td>
												<td>
													<strong>{{ isset($profile) ? $profile->phone : '--' }}</strong>
												</td>
											</tr>
											<tr>
												<td>Registered In:</td>
												<td>{{ date('F j, Y, g:i a', strtotime($user->created_at)) }}</td>
											</tr>
											<tr>
												<td>Occupation:</td>
												<td>
													{{ isset($profile) ? $profile->occupation : '--' }}
												</td>
											</tr>
											<tr>
												<td>Address:</td>
												<td>
													{{ isset($profile) ? $profile->address : '--' }}
												</td>
											</tr>
											<tr>
												<td>About {{ $user->name }}:</td>
												<td>{{ isset($profile) ? $profile->about : '--' }}</td>
											</tr>
										</tr>
									</tbody>

								</table>
							</div>
						</div>
						@if(Session::has('mailSent'))
						<div class="row-fluid">
							<div class="span12">
								<div class="alert alert-success">{!! Session::get('mailSent') !!}</div>
							</div>
						</div>
						@endif
						@if(Session::has('mailNotSent'))
						<div class="row-fluid">
							<div class="span12">
								<div class="alert alert-danger">{!! Session::get('mailNotSent') !!}</div>
							</div>
						</div>
						@endif
						@if(Session::has('messageSent'))
						<div class="row-fluid">
							<div class="span12">
								<div class="alert alert-success">{!! Session::get('messageSent') !!}</div>
							</div>
						</div>
						@endif
						<hr>
						<div class="row-fluid">
							<div class="span12 text-right">
								@if(Auth::user()->id!=$user->id)
									@if(Auth::user()->role=='visitor' && $user->role=='host')
									<a class="btn btn-info btn-mini" href="{{ route('appointments.specific', $user->id) }}">Request for Appointment</a>
									@elseif(Auth::user()->role=='visitor' && $user->role=='admin')
									<a class="btn btn-info btn-mini" href="{{ route('visits.create') }}">Request for Visit</a>
									@endif
								<button class="btn btn-info btn-mini" data-toggle="modal" data-target="#msgUser{{ $user->id }}">Send Message</button>
								
								<div id="msgUser{{ $user->id }}" class="modal hide" style="text-align: left !important">
									<form action="{{ route('inbox.store', $user->id) }}" method="POST">
									{{ csrf_field() }}
									<div class="modal-header">
										<button data-dismiss="modal" class="close" type="button">×</button>
										<h3>Message To: {{ $user->name }}</h3>
									</div>
									<div class="modal-body">
										<div class="control-group">
											<label class="control-label">Message :</label>
											<div class="controls">
												<textarea name="message" class="span12" cols="30" rows="6" placeholder="Write here" required></textarea>
												@if($errors->has('message'))
												<li class="error">{{ $errors->first('message') }}</li>
												@endif
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">Send</button>
										<button data-dismiss="modal" class="btn">Cancel</button>
									</div>
									</form>
								</div>

								<button class="btn btn-info btn-mini mailUser" data-toggle="modal" data-target="#mailUser{{ $user->id }}">Send Mail</button>
								
								@if($errors->has('subject') || $errors->has('body'))
								<script>
									$(document).ready(function(){
										$($('.mailUser').data('target')).modal('show');
									});
								</script>
								@endif

								<div id="mailUser{{ $user->id }}" class="modal hide" style="text-align: left !important">
									<form action="{{ route('mail.send', $user->id) }}" method="POST">
									{{ csrf_field() }}
									<div class="modal-header">
										<button data-dismiss="modal" class="close" type="button">×</button>
										<h3>Mail To: {{ $user->name }}</h3>
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

								@else
									@if(Auth::user()->role=='admin')
										<a class="btn btn-info btn-mini" href="{{ route('managevisits.index') }}">Manage Visit Requests</a>
									@elseif(Auth::user()->role=='host')
										<a class="btn btn-info btn-mini" href="{{ route('manageappointments.index') }}">Manage Appointment Requests</a>
									@elseif(Auth::user()->role=='visitor')
										<a class="btn btn-info btn-mini" href="{{ route('visits.index') }}">My Visit Requests</a>
										<a class="btn btn-info btn-mini" href="{{ route('appointments.index') }}">My Appointment Requests</a>
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
