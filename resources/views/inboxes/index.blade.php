@extends('layouts.ap')

@section('title', 'Inbox')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('inbox.index') }}" class="current">Inbox</a></div>
		{{-- <h1>Add Designation</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>

		@if(Session::has('messageSent'))
		<div class="row-fluid">
			<div class="span12">
				<div class="alert alert-success">{!! Session::get('messageSent') !!}</div>
			</div>
		</div>
		@endif

		@if($messages->isEmpty())
			<div class="alert alert-warning">No message</div>
		@else
			@foreach($messages as $message)
				<div class="message-box">
					<div class="info">
						<a href="{{ route('profiles.show', $message->senderId) }}">
						@if(!isset($message->sender->profile))
							<img src="{{ asset('images/avatar/noimage.png') }}" class="img-polaroid" width="15px" height="15px" alt="">
						@else
							<img src="{{ asset('images/avatar/'.$message->sender->profile->avatar) }}" class="img-polaroid" width="15px" height="15px" alt="">
						@endif
						</a>
						&nbsp;&nbsp;
						<a class="msg-name" href="{{ route('profiles.show', $message->senderId) }}">{{ $message->sender->name }}</a>
					</div>
					<br>
					<div class="msg">
						{!! nl2br($message->message) !!}
					</div>
					<br>
					<div class="msg-action">
						<i class="fa fa-calendar"></i>&nbsp;&nbsp;{{ date('F j, Y, g:i a', strtotime($message->created_at)) }}
						&nbsp;&nbsp;&nbsp;
						<button class="btn btn-info btn-mini" data-toggle="modal" data-target="#msgUser{{ $message->senderId }}">Reply</button>

						<div id="msgUser{{ $message->senderId }}" class="modal hide" style="text-align: left !important">
							<form action="{{ route('inbox.store', $message->senderId) }}" method="POST">
							{{ csrf_field() }}
							<div class="modal-header">
								<button data-dismiss="modal" class="close" type="button">×</button>
								<h3>Message To: {{ $message->sender->name }}</h3>
							</div>
							<div class="modal-body">
								<div class="row-fluid">
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
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">Send</button>
								<button data-dismiss="modal" class="btn">Cancel</button>
							</div>
							</form>
						</div>
					</div>
				</div>
				<br>
			@endforeach
		@endif
	</div>
</div>

@endsection