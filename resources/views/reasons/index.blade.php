@extends('layouts.ap')

@section('title', 'Visit Reasons')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visitreasons.index') }}" class="current">Visit Reasons</a></div>
		{{-- <h1>Visit Reasons</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span10 offset1">
				@if(Session::has('visitReasonUpdated'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Session::get('visitReasonUpdated') }}
				</div>
				@endif
				@if(Session::has('reasonDeleted'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Session::get('reasonDeleted') }}
				</div>
				@endif
				@if(Session::has('reasonDeleteFailed'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Session::get('reasonDeleteFailed') }}
				</div>
				@endif

				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Reasons List</h5>
					</div>

					<div class="widget-content nopadding">
						@if($reasons->isEmpty())
							<div class="alert alert-warning">No reason found! <a href="{{ route('visitreasons.create') }}">Add new</a></div>
						@else
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Name</th>
									<th>Created At</th>
									<th>Updated At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@php($count=0)
								@foreach($reasons as $reason)
								@php($count++)
								<tr>
									<td>{{ $count }}</td>
									<td>{{ ucwords($reason->name) }}</td>
									<td>{{ date('F j, Y, g:i a', strtotime($reason->created_at)) }}</td>
									<td>{{ date('F j, Y, g:i a', strtotime($reason->updated_at)) }}</td>
									<td>
										<button class="btn btn-info btn-mini" data-toggle="modal" data-target="#editReasonModal{{ $reason->id }}"><i class="fa fa-pencil" aria-hidden="true"></i></button>

										<div id="editReasonModal{{ $reason->id }}" class="modal hide">
											<form action="{{ route('visitreasons.update', $reason->id) }}" method="POST">
											{{ csrf_field() }}
											{{ method_field('PUT') }}
											<div class="modal-header">
												<button data-dismiss="modal" class="close" type="button">×</button>
												<h3>Edit</h3>
											</div>
											<div class="modal-body">
												<div class="control-group">
													<label class="control-label">Name of Reason :</label>
													<div class="controls">
														<input type="text" class="span12" name="name" placeholder="Reason name" value="{{ $reason->name }}" required>
														@if($errors->has('name'))
														<li class="error">{{ $errors->first('name') }}</li>
														@endif
														<span class="help-block">Reason name should be unique</span>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-primary">Save</button>
												<button data-dismiss="modal" class="btn">Cancel</button>
											</div>
											</form>
										</div>

										<form action="{{ route('visitreasons.destroy', $reason->id) }}" method="POST" class="form-inline">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
											<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?')"><i class="fa fa-trash" aria-hidden="true"></i></button>
										</form>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@endif
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection