@extends('layouts.auth')

@section('title', 'Registration')

@section('body')
	<div class="auth">
		<h1><a href="#"><i class="fa fa-ravelry" aria-hidden="true"></i> E-Reception</a></h1>

		<div class="auth-bottom">
			<h2>Visitor Signup</h2>
			
			@if(!$errors->isEmpty())
			<div class="col-md-12">
				@foreach($errors->all() as $error)
				<li class="auth-error"><i class="fa fa-exclamation-circle"></i> {{ $error }}</li>
				@endforeach
				<br>
			</div>
			@endif

			<form action="{{ route('postRegister') }}" method="POST">
				{{ csrf_field() }}
				<div class="col-md-6">
					<div class="auth-mail">
						<input type="text" name="name" placeholder="Name" value="{{ old('name') }}" required>
						<i class="fa fa-user"></i>
					</div>

					<div class="auth-mail">
						<input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
						<i class="fa fa-envelope"></i>
					</div>
					<input type="hidden" name="role" value="visitor">
					<div class="auth-mail">
						<input type="password" name="password" placeholder="Password" required>
						<i class="fa fa-lock"></i>
					</div>
					<div class="auth-mail">
						<input type="password" name="password_confirmation" placeholder="Repeat password" required>
						<i class="fa fa-lock"></i>
					</div>
					<label for="agree"><input type="checkbox" name="agree" id="agree" required> <span class="agree">I agree with the terms!</span></label>
				</div>
				<div class="col-md-6 auth-do">
					<label class="hvr-shutter-in-horizontal auth-sub">
						<input type="submit" value="Submit">
					</label>
					<p>Already registered?</p>
					<a href="{{ route('login') }}" class="hvr-shutter-in-horizontal">Login</a>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>
	</div>

	<div class="copy-right">
		<p>&copy; 2017 ER. All Rights Reserved | Developed by Anonymous</p>
	</div>

@endsection