@extends('layouts.ap')

@section('title', 'Hosts')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('hosts.index') }}" class="current">Hosts</a></div>
		{{-- <h1>Hosts</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span10 offset1">
				@if(Session::has('hostDeleteSuccess'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Session::get('hostDeleteSuccess') }}
				</div>
				@endif
				@if(Session::has('hostDeleteFailed'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Session::get('hostDeleteFailed') }}
				</div>
				@endif
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

				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Hosts List</h5>
					</div>

					<div class="widget-content nopadding">
						@if($hosts->isEmpty())
							<div class="alert alert-warning">No host found! <a href="{{ route('hosts.create') }}">Add new</a></div>
						@else
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Name</th>
									<th>Email</th>
									<th>Designation</th>
									<th>Registered At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@php($count=0)
								@foreach($hosts as $host)
								@php($count++)
								<tr>
									<td>{{ $count }}</td>
									<td>{{ $host->name }}</td>
									<td>{{ $host->email }}</td>
									<td>{{ ucwords($host->designation) }}</td>
									<td>{{ date('F j, Y, g:i a', strtotime($host->created_at)) }}</td>
									<td>
										<a class="btn btn-success btn-mini tip-left" title="View Profile" href="{{ route('profiles.show', $host->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>

										<button class="btn btn-info btn-mini tip-top mailUser" data-toggle="modal" data-target="#mailUser{{ $host->id }}"><i class="fa fa-envelope" aria-hidden="true"></i></button>

										@if($errors->has('subject') || $errors->has('body'))
										<script>
											$(document).ready(function(){
												$($('.mailUser').data('target')).modal('show');
											});
										</script>
										@endif

										<div id="mailUser{{ $host->id }}" class="modal hide" style="text-align: left !important">
											<form action="{{ route('mail.send', $host->id) }}" method="POST">
											{{ csrf_field() }}
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">×</button>
												<h3>Mail To: {{ $host->name }}</h3>
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

										<form action="{{ route('hosts.destroy', $host->id) }}" method="POST" class="form-inline tip-bottom" title="Remove {{ $host->name }}">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
											<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></button>
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