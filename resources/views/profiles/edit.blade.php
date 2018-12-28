@extends('layouts.ap')

@section('title', 'Edit Profile | '.Auth::user()->name)

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('profiles.index') }}" class="tip-bottom">Profiles</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('profiles.show', Auth::user()->id) }}" class="current">{{ Auth::user()->name }}</a></div>
		{{-- <h1>Add Designation</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="fa fa-align-justify" aria-hidden="true"></i> </span>
						<h5>Update User Profile</h5>
					</div>
					<div class="widget-content">
						<form action="{{ route('profiles.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
							<div class="row-fluid">
								<div class="span6">
									{{-- @if(Session::has('designationAddSuccess'))
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										{{ Session::get('designationAddSuccess') }}
									</div>
									@endif --}}
									{{ csrf_field() }}
									{{ method_field('PUT') }}

									<div class="control-group">
										<label class="control-label">Name :</label>
										<div class="controls">
											<input type="text" class="span11" name="name" placeholder="Name" value="{{ Auth::user()->name }}" required>
											@if($errors->has('name'))
											<li class="error">{{ $errors->first('name') }}</li>
											@endif
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Email :</label>
										<div class="controls">
											<input type="email" class="span11" name="email" placeholder="Email" value="{{ Auth::user()->email }}" readonly>
											{{-- @if($errors->has('name'))
											<li class="error">{{ $errors->first('name') }}</li>
											@endif --}}
											<span class="help-block">You can't change email</span>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">User Role :</label>
										<div class="controls">
											<input type="text" class="span11" name="role" placeholder="Role" value="{{ Auth::user()->role }}" readonly>
											{{-- @if($errors->has('name'))
											<li class="error">{{ $errors->first('name') }}</li>
											@endif --}}
											<span class="help-block">You can't change role</span>
										</div>
									</div>
								</div>

								<div class="span6">
									<div class="control-group">
										<label class="control-label">Phone No :</label>
										<div class="controls">
											<input type="text" class="span11" name="phone" placeholder="Phone No" value="{{ isset($profile) ? $profile->phone : '' }}" required>
											@if($errors->has('phone'))
											<li class="error">{{ $errors->first('phone') }}</li>
											@endif
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Address :</label>
										<div class="controls">
											<input type="text" class="span11" name="address" placeholder="Address" value="{{ isset($profile) ? $profile->address : '' }}" required>
											@if($errors->has('address'))
											<li class="error">{{ $errors->first('address') }}</li>
											@endif
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Occupation :</label>
										<div class="controls">
											<input type="text" class="span11" name="occupation" placeholder="Occupation" value="{{ isset($profile) ? $profile->occupation : '' }}" required>
											@if($errors->has('occupation'))
											<li class="error">{{ $errors->first('occupation') }}</li>
											@endif
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Profile Avatar :</label>
										<div class="controls">
											@if(isset($profile) && $profile->avatar!=NULL)
											<input type="file" name="avatar">
											@else
											<input type="file" name="avatar" required>
											@endif
											@if($errors->has('avatar'))
											<li class="error">{{ $errors->first('avatar') }}</li>
											@endif
										</div>
									</div>
								</div>
							</div>
							
							<div class="row-fluid">
								<div class="span12">
									<div class="control-group">
										<label class="control-label">About You :</label>
										<div class="controls">
											<textarea name="about" class="span11" cols="30" rows="10" placeholder="About You" required>{{ isset($profile) ? $profile->about : '' }}</textarea>
											@if($errors->has('about'))
											<li class="error">{{ $errors->first('about') }}</li>
											@endif
										</div>
									</div>
								</div>
							</div>

							<div class="row-fluid">
								<div class="span12">
									<button type="submit" class="btn btn-success">Update</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

@endsection