@extends('layouts.ap')

@section('title', 'Check Visit Card')

@section('body')

<div id="content">
	<div id="content-header">
		<div id="breadcrumb"> <a href="{{ route('dashboard') }}" title="Dashboard" class="tip-bottom"><i class="fa fa-home" aria-hidden="true"></i> Home</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <a href="{{ route('checkVisits.index') }}" class="tip-bottom current">Check Visit Card</a></div>
		{{-- <h1>Visitors</h1> --}}
	</div>
	
	<div class="container-fluid">
		{{-- <hr> --}}
		<br><br>
		<div class="row-fluid">
			<div class="span8 offset2">
				
				<div class="widget-box">
					<div class="widget-title"> <span class="icon"><i class="fa fa-th"></i></span>
						<h5>Check Visit Card</h5>
					</div>

					<div class="widget-content">
						<div class="row-fluid">
							<div class="span6">
								<p>Avatar:</p>
								<img src="{{ asset('images/avatar/'.$visit->visitor->profile->avatar) }}" class="img-polaroid" width="170px" height="170px" alt="">
							</div>
							<div class="span6">
								{{-- @if(Session::has('visitRequestSent'))
								<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									{{ Session::get('visitRequestSent') }}
								</div>
								@endif
								@if(Session::has('visitUpdateSuccess'))
								<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">&times;</button>
									{{ Session::get('visitUpdateSuccess') }}
								</div>
								@endif --}}
								<table class="table table-bordered table-invoice">
									<tbody>
										<tr>
											<tr>
												<td class="width30">Name:</td>
												<td class="width70"><b><a href="{{ route('profiles.show', $visit->visitorId) }}">{{ $visit->visitor->name }}</a></b></td>
											</tr>
											<tr>
												<td>Email:</td>
												<td>{{ $visit->visitor->email }}</td>
											</tr>
											<tr>
												<td>Phone:</td>
												<td>{{ $visit->visitor->profile->phone }}</td>
											</tr>
											<tr>
												<td>Purpose:</td>
												<td>{{ $visit->reason->name }}</td>
											</tr>
											<tr>
												<td>Visit Schedule:</td>
												<td><strong>{{ date('F j, Y', strtotime($visit->vDate)) }}, {{ $visit->vTime }}</strong></td>
											</tr>
											<tr>
												<td>Applied At:</td>
												<td>
													<strong>{{ date('F j, Y, g:i a', strtotime($visit->created_at)) }}</strong>
												</td>
											</tr>
											<tr>
												<td>Applied To:</td>
												<td><b><a href="{{ route('profiles.show', $visit->adminId) }}">{{ $visit->admin->name }}</a></b></td>
											</tr>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="row-fluid">
							<div class="span12">
								@if(!isset($report))
									<form action="{{ route('checkVisits.proceed') }}" method="POST">
									{{ csrf_field() }}
									<input type="hidden" name="visitId" value="{{ $visit->id }}">
									<button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i> Proceed In</button>
									</form>
								@else
									@if($report->status==0)
									<form action="{{ route('checkVisits.terminate') }}" method="POST">
									{{ csrf_field() }}
									<input type="hidden" name="reportId" value="{{ $report->id }}">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check" aria-hidden="true"></i> Proceed Out</button>
									</form>

									@elseif($report->status==1)
									<div class="alert alert-danger">Task Completed</div>
									@endif
								@endif
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection