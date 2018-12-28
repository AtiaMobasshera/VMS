@extends('layouts.ap')

@section('title', 'Request for visit')

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
			startDate: '+1d',
			todayHighlight: true
		});

		// $('#vTime').timepicker({
		// 	defaultTime: false
		// });

		$('.reasonsList').select2();
		$('.timesList').select2();
	});
</script>
@endsection

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visits.index') }}" class="tip-bottom">My Visit Requests</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visits.create') }}" class="current">Create</a></div>
		{{-- <h1>Request For Visit</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span8 offset2">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="fa fa-align-justify" aria-hidden="true"></i> </span>
						<h5>Visit Request Form</h5>
					</div>
					<div class="widget-content nopadding">
						<form action="{{ route('visits.store') }}" method="POST" class="form-horizontal">
							{{ csrf_field() }}

							@if(!isset(Auth::user()->profile))
							<div class="alert alert-danger">Update your profile first. <a href="{{ route('profiles.update', Auth::user()->id) }}">Update now</a></div>
							@endif

							@if(Session::has('visitRequestNotSent'))
							<div class="alert alert-danger">{!! Session::get('visitRequestNotSent') !!}</div>
							@endif

							<div class="control-group">
								<label class="control-label">Request To :</label>
								<div class="controls">
									<input type="text" class="span6" value="Administrator" readonly>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pick visit date :</label>
								<div class="controls">
									<input type="text" class="span6" id="vDate" name="vDate" placeholder="Pick date" value="{{ old('vDate') }}" required>
									@if($errors->has('vDate'))
									<li class="error">{{ $errors->first('vDate') }}</li>
									@endif
									@if(Session::has('visitRequestNotSent'))
									<li class="error">Choose another date</li>
									@endif
									<span class="help-block">Date with Format (yyyy-mm-dd)</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pick visit time :</label>
								<div class="controls">
									{{-- <input type="text" class="span6" id="vTime" name="vTime" placeholder="Pick time" required> --}}
									@php($times=['10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM', '4:00 PM', '5:00 PM'])
									<select name="vTime" class="span6 timesList" required>
										<option value="">Pick time...</option>
										@foreach($times as $time)
											@if(old('vTime')==$time)
											<option selected value="{{ $time }}">{{ $time }}</option>
											@else
											<option value="{{ $time }}">{{ $time }}</option>
											@endif
										@endforeach
									</select>
									@if($errors->has('vTime'))
									<li class="error">{{ $errors->first('vTime') }}</li>
									@endif
									@if(Session::has('visitRequestNotSent'))
									<li class="error">Choose another time</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pick a reason :</label>
								<div class="controls">
									<select name="reasonId" class="span6 reasonsList" required>
										<option value="">Chose visit reason...</option>
										@if(!$reasons->isEmpty())
											@foreach($reasons as $reason)
												@if(old('reasonId')==$reason->id)
												<option selected value="{{ $reason->id }}">{{ ucwords($reason->name) }}</option>
												@else
												<option value="{{ $reason->id }}">{{ ucwords($reason->name) }}</option>
												@endif
											@endforeach
										@endif
									</select>
									@if($errors->has('reasonId'))
									<li class="error">{{ $errors->first('reasonId') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Why you want to visit :</label>
								<div class="controls">
									<textarea class="span11" name="purpose" cols="30" rows="7" required>{{ old('purpose') }}</textarea>
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

@endsection
