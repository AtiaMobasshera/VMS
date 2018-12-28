@extends('layouts.ap')

@section('title', 'Visits Today')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visitReports.index') }}">Visit Reports</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('visitReports.today') }}" class="current">Today</a></div>
		{{-- <h1>Visitors</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span12">
				{{-- @if(Session::has('visitorDeleteSuccess'))
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Session::get('visitorDeleteSuccess') }}
				</div>
				@endif
				@if(Session::has('visitorDeleteFailed'))
				<div class="alert alert-danger">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					{{ Session::get('visitorDeleteFailed') }}
				</div>
				@endif
				@if(Session::has('mailSent'))
				<div class="row-fluid">
					<div class="span12">
						<div class="alert alert-success">{!! Session::get('mailSent') !!}</div>
					</div>
				</div>
				@endif --}}
				
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Visits Today</h5>
					</div>

					<div class="widget-content nopadding">
						@if($reports->isEmpty())
							<div class="alert alert-warning">No visit today!</div>
						@else
						<table class="table table-bordered data-table">
							<thead>
								<tr>
									<th>Sl</th>
									<th>From - To</th>
									<th>Purpose</th>
									<th>Visit Schedule</th>
									<th>Applied At</th>
									<th>Entry</th>
									<th>Exit</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								@php($count=0)
								@foreach($reports as $report)
								@php($count++)
								<tr>
									<td>{{ $count }}</td>
									<td>
										From: <a href="{{ route('profiles.show', $report->visit->visitorId) }}">{{ $report->visit->visitor->name }}</a>
										<br>
										To: <a href="{{ route('profiles.show', $report->visit->adminId) }}">{{ $report->visit->admin->name }}</a>
									</td>
									<td>{{ $report->visit->reason->name }}</td>
									<td>{{ date('F j, Y', strtotime($report->visit->vDate)) }}, {{ $report->visit->vTime }}</td>
									<td>{{ date('F j, Y, g:i a', strtotime($report->visit->created_at)) }}</td>
									<td>{{ date('F j, Y, g:i a', strtotime($report->entryTimestamp)) }}</td>
									<td>
										@if($report->exitTimestamp!=NULL)
										{{ date('F j, Y, g:i a', strtotime($report->exitTimestamp)) }}
										@else
										<span style="color: red">No</span>
										@endif
									</td>
									<td>
										@if($report->status==1)
										<span class="label label-success">Completed</span>
										@elseif($report->status==0)
										<span class="label label-warning">Not Completed</span>
										@endif
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