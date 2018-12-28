@extends('layouts.ap')

@section('title', 'Add Visit Reason')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visitreasons.index') }}" class="tip-bottom">Visit Reasons</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visitreasons.create') }}" class="current">Create</a></div>
		{{-- <h1>Add Visit Reason</h1> --}}
	</div>
	
	<div class="container-fluid">
		<br><br>
		{{-- <hr> --}}
		<div class="row-fluid">
			<div class="span6 offset3">
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"> <i class="fa fa-align-justify" aria-hidden="true"></i> </span>
						<h5>Add Visit Reason</h5>
					</div>
					<div class="widget-content nopadding">
						<form action="{{ route('visitreasons.store') }}" method="POST" class="form-horizontal">
							@if(Session::has('reasonAddSuccess'))
							<div class="alert alert-success">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								{{ Session::get('reasonAddSuccess') }}
							</div>
							@endif

							{{ csrf_field() }}
							<div class="control-group">
								<label class="control-label">Name of Reason :</label>
								<div class="controls">
									<input type="text" class="span11" name="name" placeholder="Reason name" required>
									@if($errors->has('name'))
									<li class="error">{{ $errors->first('name') }}</li>
									@endif
									<span class="help-block">Reason name should be unique</span>
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