@extends('layouts.ap')

@section('title', 'Immediate Appointments')

@section('css')
<link rel="stylesheet" href="{{ asset('css/ap/select2.min.css') }}">
@endsection

@section('topJs')
<script>
	$(document).ready(function(){
		$('.reasonsList').select2();
		$('.hostsList').select2();
	});
</script>
@endsection

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('immediateappointments.index') }}" class="tip-bottom">Immediate Appointments</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('immediateappointments.create') }}" class="current">Create</a></div>
		{{-- <h1>Request For Visit</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span6 offset3">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="fa fa-align-justify" aria-hidden="true"></i> </span>
						<h5>Immediate Appointment Form</h5>
					</div>
					<div class="widget-content nopadding">
						<form action="{{ route('immediateappointments.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
							{{ csrf_field() }}
							<div class="control-group">
								<label class="control-label">To :</label>
								<div class="controls">
									<select name="hostId" class="span6 hostsList" required>
										<option value="">Chose host...</option>
										@if(!$hosts->isEmpty())
											@foreach($hosts as $host)
											<option value="{{ $host->id }}">{{ ucwords($host->name) }}</option>
											@endforeach
										@endif
									</select>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Visitor Name :</label>
								<div class="controls">
									<input type="text" name="name" class="span11" placeholder="Visitor name" required>
									@if($errors->has('name'))
									<li class="error">{{ $errors->first('name') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Visitor Email :</label>
								<div class="controls">
									<input type="email" name="email" class="span11" placeholder="Visitor email" required>
									@if($errors->has('email'))
									<li class="error">{{ $errors->first('email') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Visitor Phone :</label>
								<div class="controls">
									<input type="number" name="phone" class="span11" placeholder="Visitor phone" required>
									@if($errors->has('phone'))
									<li class="error">{{ $errors->first('phone') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Visitor Occupation :</label>
								<div class="controls">
									<input type="text" name="occupation" class="span11" placeholder="Visitor occupation" required>
									@if($errors->has('occupation'))
									<li class="error">{{ $errors->first('occupation') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Visitor Image :</label>
								<div class="controls">
									<input type="file" name="avatar" required>
									@if($errors->has('avatar'))
									<li class="error">{{ $errors->first('avatar') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Pick Reason :</label>
								<div class="controls">
									<select name="reason" class="span6 reasonsList" required>
										<option value="">Chose visit reason...</option>
										@if(!$reasons->isEmpty())
											@foreach($reasons as $reason)
											<option value="{{ $reason->name }}">{{ ucwords($reason->name) }}</option>
											@endforeach
										@endif
									</select>
									@if($errors->has('reasonId'))
									<li class="error">{{ $errors->first('reasonId') }}</li>
									@endif
								</div>
							</div>

							<div class="form-actions">
								<button type="submit" class="btn btn-success">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('bottomJs')
<script src="{{ asset('js/ap/select2.min.js') }}"></script>

@endsection