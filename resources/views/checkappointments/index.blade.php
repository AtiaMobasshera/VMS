@extends('layouts.ap')

@section('title', 'Check Appointment Card')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('checkAppointments.index') }}" class="tip-bottom current">Check Appointment Card</a></div>
		{{-- <h1>Add Designation</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span6 offset3">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="fa fa-align-justify" aria-hidden="true"></i> </span>
						<h5>Check Appointment Card</h5>
					</div>
					<div class="widget-content nopadding">
						<form action="{{ route('checkAppointments.check') }}" method="POST" class="form-horizontal">
							@if(Session::has('invalidCode'))
							<div class="alert alert-danger">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								{{ Session::get('invalidCode') }}
							</div>
							@endif

							@if(Session::has('proceedSuccess'))
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								{{ Session::get('proceedSuccess') }}
							</div>
							@endif

							@if(Session::has('terminateSuccess'))
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								{{ Session::get('terminateSuccess') }}
							</div>
							@endif

							{{ csrf_field() }}
							<div class="control-group">
								<label class="control-label">Enter Appointment Access Code :</label>
								<div class="controls">
									<input type="text" class="span11" name="code" placeholder="Access code" required>
									@if($errors->has('code'))
									<li class="error">{{ $errors->first('code') }}</li>
									@endif
									<span class="help-block">Access code is provided in Appointment Card</span>
								</div>
							</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-success">Check In</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection