@extends('layouts.ap')

@section('title', 'Request for Appointment')

@section('css')
<link rel="stylesheet" href="{{ asset('css/ap/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/ap/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/ap/select2.min.css') }}">
@endsection

@section('topJs')
<script>
	$(document).ready(function(){
		$('#vDate').datepicker({
			format: 'yyyy-mm-dd',
			startDate: 'today',
			todayHighlight: true
		});

		$('#vTime').timepicker({
			defaultTime: false
		});

		$('.reasonsList').select2();

		$('.hostsList').select2();
	});
</script>
@endsection

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('appointments.index') }}" class="tip-bottom">My Appointment Requests</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('appointments.create') }}" class="current">Create</a></div>
		{{-- <h1>Request For Visit</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span8 offset2">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="fa fa-align-justify" aria-hidden="true"></i> </span>
						<h5>Appointment Request Form</h5>
					</div>
					<div class="widget-content nopadding">
						<form action="{{ route('appointments.store') }}" method="POST" class="form-horizontal">
							{{ csrf_field() }}

							@if(!isset(Auth::user()->profile))
							<div class="alert alert-danger">Update your profile first. <a href="{{ route('profiles.update', Auth::user()->id) }}">Update now</a></div>
							@endif

							<div class="control-group">
								<label class="control-label">Request To :</label>
								<div class="controls">
									<select name="hostId" class="span6 hostsList" required>
										@if(!$hosts->isEmpty())
											@foreach($hosts as $host)
												@if($host->id==$hst)
												<option value="{{ $host->id }}" selected>{{ $host->name }}( {{ $host->hostDesignation->designation->name }} )</option>
												@endif
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pick appointment date :</label>
								<div class="controls">
									<input type="text" class="span6" id="vDate" name="vDate" placeholder="Pick date" required>
									@if($errors->has('vDate'))
									<li class="error">{{ $errors->first('vDate') }}</li>
									@endif
									<span class="help-block">Date with Format (yyyy-mm-dd)</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pick appointment time :</label>
								<div class="controls">
									<input type="text" class="span6" id="vTime" name="vTime" placeholder="Pick time" required>
									@if($errors->has('vTime'))
									<li class="error">{{ $errors->first('vTime') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pick a reason :</label>
								<div class="controls">
									<select name="reasonId" class="span6 reasonsList" required>
										<option value="">Chose reason...</option>
										@if(!$reasons->isEmpty())
											@foreach($reasons as $reason)
											<option value="{{ $reason->id }}">{{ ucwords($reason->name) }}</option>
											@endforeach
										@endif
									</select>
									@if($errors->has('reasonId'))
									<li class="error">{{ $errors->first('reasonId') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Your purpose(In brief) :</label>
								<div class="controls">
									<textarea class="span11" name="purpose" cols="30" rows="7" required></textarea>
									@if($errors->has('purpose'))
									<li class="error">{{ $errors->first('purpose') }}</li>
									@endif
									<span class="help-block">At least 20 words</span>
								</div>
							</div>
							
							@if(isset(Auth::user()->profile))
							<div class="form-actions">
								<button type="submit" class="btn btn-success">Save</button>
							</div>
							@endif
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('bottomJs')
<script src="{{ asset('js/ap/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/ap/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('js/ap/select2.min.js') }}"></script>
{{-- <script>
	$(document).ready(function(){
		$('#hostList').select2();
	});
</script> --}}

@endsection
