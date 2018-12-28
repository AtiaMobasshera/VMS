@extends('layouts.ap')

@section('title', 'Visit Requests')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visits.index') }}" class="current">My Visit Requests</a></div>
		{{-- <h1>Visitors</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				<div class="text-right">
					<a href="{{ route('visits.approved') }}" class="btn btn-success btn-mini">Approved</a>
					<a href="{{ route('visits.pending') }}" class="btn btn-warning btn-mini">Pending</a>
					<a href="{{ route('visits.rejected') }}" class="btn btn-inverse btn-mini">Rejected</a>
				</div>
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Visit Requests</h5>
					</div>

					<div class="widget-content nopadding">
						@if($visits->isEmpty())
							<div class="alert alert-warning">No visit requests found!</div>
						@else
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Sl</th>
									<th>To</th>
									<th>Reason Tag</th>
									<th>Purpose</th>
									<th>Visit Schedule</th>
									<th>Applied At</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@php($count=0)
								@foreach($visits as $visit)
								@php($count++)
								<tr>
									<td>{{ $count }}</td>
									<td><a href="{{ route('profiles.show', $visit->adminId) }}">{{ $visit->admin->name }}</a></td>
									<td>{{ $visit->reason->name }}</td>
									<td>{!! substr(ucfirst(nl2br($visit->purpose)), 0, 40) !!}</td>
									<td>{{ date('F j, Y', strtotime($visit->vDate)) }}, {{ $visit->vTime }}</td>
									<td>{{ date('F j, Y, g:i a', strtotime($visit->created_at)) }}</td>
									<td>
										@if($visit->status==0)
										<span class="label label-warning">Pending</span>
										@elseif($visit->status==1)
										<span class="label label-success">Approved</span>
										@elseif($visit->status==-1)
										<span class="label label-inverse">Denied</span>
										@endif
									</td>
									<td>
										{{-- <a class="btn btn-inverse btn-mini" title="Email"><i class="fa fa-envelope" aria-hidden="true"></i></a> --}}

										{{-- <button class="btn btn-success btn-mini" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a></button> --}}
										<a class="btn btn-success btn-mini" href="{{ route('visits.show', $visit->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>

										<a class="btn btn-info btn-mini tip-left" href="{{ route('visits.edit', $visit->id) }}" {{ $visit->status==1 || $visit->status==-1 ? 'disabled' : '' }}><i class="fa fa-pencil" aria-hidden="true"></i></a>

										<form action="{{ route('visits.destroy', $visit->id) }}" method="POST" class="form-inline tip-bottom">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
											<button type="submit" class="btn btn-danger btn-mini" onclick="return confirm('Are you sure?')" {{ $visit->status==-1 ? 'disabled' : '' }}><i class="fa fa-trash" aria-hidden="true"></i></button>
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