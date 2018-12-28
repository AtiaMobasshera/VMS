@extends('layouts.ap')

@section('title', 'Add Host')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('hosts.index') }}" class="tip-bottom">Hosts</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('hosts.create') }}" class="current">Create</a></div>
		{{-- <h1>Add Host</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span6 offset3">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="fa fa-align-justify" aria-hidden="true"></i> </span>
						<h5>Add Host</h5>
					</div>
					<div class="widget-content nopadding">
						<form action="{{ route('hosts.store') }}" method="POST" class="form-horizontal">
							@if(Session::has('hostAddSuccess'))
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								{{ Session::get('hostAddSuccess') }}
							</div>
							@endif

							{{ csrf_field() }}
							<div class="control-group">
								<label class="control-label">Host's Name :</label>
								<div class="controls">
									<input type="text" class="span11" name="name" placeholder="Host name" required>
									@if($errors->has('name'))
									<li class="error">{{ $errors->first('name') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Host's Email :</label>
								<div class="controls">
									<input type="email" class="span11" name="email" placeholder="Host email" required>
									@if($errors->has('email'))
									<li class="error">{{ $errors->first('email') }}</li>
									@endif
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Host's Designation :</label>
								<div class="controls">
									<select class="span11" name="designationId" required>
										<option value="">Chose Designation...</option>
										@if(!$designations->isEmpty())
											@foreach($designations as $designation)
											<option value="{{ $designation->id }}">{{ ucwords($designation->name) }}</option>
											@endforeach
										@endif
									</select>
									@if($errors->has('designation'))
									<li class="error">{{ $errors->first('designation') }}</li>
									@endif
								</div>
							</div>
							<input type="hidden" name="role" value="host">
							<div class="control-group">
								<label class="control-label">Host's Password :</label>
								<div class="controls">
									<input type="password" class="span11" name="password" placeholder="Host password" required>
									<span class="help-block">At least 5 digits</span>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label">Repeat Password :</label>
								<div class="controls">
									<input type="password" class="span11" name="password_confirmation" placeholder="Repeat password" required>
									@if($errors->has('password'))
									<li class="error">{{ $errors->first('password') }}</li>
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