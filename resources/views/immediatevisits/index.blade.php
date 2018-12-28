@extends('layouts.ap')

@section('title', 'Immediate Visits')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('immediatevisits.index') }}" class="current">Immediate Visits</a></div>
		{{-- <h1>Visitors</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				<div class="text-right">
					<a href="{{ route('immediatevisits.create') }}" class="btn btn-info btn-mini"><i class="fa fa-plus" aria-hidden="true"></i> Add Immediate Visitor</a>
				</div>

				@if(Session::has('ivAdded'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{!! Session::get('ivAdded') !!}
				</div>
				@endif

				@if(Session::has('ivDeleted'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{!! Session::get('ivDeleted') !!}
				</div>
				@endif
				
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Immediate Visits</h5>
					</div>

					<div class="widget-content nopadding">
						@if($ivs->isEmpty())
							<div class="alert alert-warning">No immediate visits found!</div>
						@else
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Avatar</th>
									<th>Visitor</th>
									<th>Occupation</th>
									<th>To</th>
									<th>Purpose</th>
									<th>Schedule</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@php($count=0)
								@foreach($ivs as $iv)
								@php($count++)
								<tr>
									<td>{{ $count }}</td>
									<td><img src="{{ asset('images/avatar/'.$iv->avatar) }}" width="50px" height="50px" alt=""></td>
									<td>Name: <b>{{ $iv->name }}</b><br>Email: {{ $iv->email }}<br>Phone: {{ $iv->phone }}</td>
									<td>{{ ucwords($iv->occupation) }}</td>
									<td><a href="{{ route('profiles.show', $iv->adminId) }}">{{ $iv->admin->name }}</a></td>
									<td>{{ ucwords($iv->purpose) }}</td>
									<td>{{ date('F j, Y, g:i a', strtotime($iv->created_at)) }}</td>
									<td>
										@if($iv->status==1)
										<span class="label label-success">Completed</span>
										@elseif($iv->status==0)
										<span class="label label-warning">Not Completed</span>
										@endif
									</td>
									<td>
										<form action="{{ route('immediatevisits.destroy', $iv->id) }}" method="POST" class="form-inline tip-bottom">
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