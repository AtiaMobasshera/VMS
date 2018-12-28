@extends('layouts.auth')

@section('title', 'Login')

@section('body')
	<div class="auth">
		<h1><a href="#"><i class="fa fa-ravelry" aria-hidden="true"></i> E-Reception</a></h1>

		<div class="auth-bottom">
			<h2>Login</h2>

			@if(!$errors->isEmpty())
			<div class="col-md-12">
				@foreach($errors->all() as $error)
				<li class="auth-error"><i class="fa fa-exclamation-circle"></i> {{ $error }}</li>
				@endforeach
				<br>
			</div>
			@endif

			<form action="{{ route('postLogin') }}" method="POST">
				{{ csrf_field() }}
				<div class="col-md-6">
					<div class="auth-mail">
						<input type="email" name="email" placeholder="Email" required>
						<i class="fa fa-envelope"></i>
					</div>
					<div class="auth-mail">
						<input type="password" name="password" placeholder="Password" required>
						<i class="fa fa-lock"></i>
					</div>
					<label for="remember"><input type="checkbox" name="remember" id="remember"> <span class="remember">Remember me?</span></label>
				</div>
				<div class="col-md-6 auth-do">
					<label class="hvr-shutter-in-horizontal auth-sub">
						<input type="submit" value="Login">
					</label>
					<p>Do not have an account?</p>
					<a href="{{ route('register') }}" class="hvr-shutter-in-horizontal">Register</a>
				</div>
				<div class="clearfix"></div>
			</form>
		</div>
	</div>

	<div class="copy-right">
		<p>&copy; 2017 ER. All Rights Reserved | Developed by Anonymous</p>
	</div>

@endsection