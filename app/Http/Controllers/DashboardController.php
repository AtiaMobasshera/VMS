<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Visit;
use App\Appointment;
use App\VisitReport;
use App\AppointmentReport;
use Auth;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function dashboard()
    {
    	$visitors=User::where('role', 'visitor')->get()->count();
    	$hosts=User::where('role', 'host')->get()->count();

    	if(Auth::user()->role=='admin' || Auth::user()->role=='receptionist'){
	    	$visitRequests=Visit::all()->count();
	    	$approvedVisitRequests=Visit::where('status', 1)->get()->count();
	    	$pendingVisitRequests=Visit::where('status', 0)->get()->count();
	    	$rejectedVisitRequests=Visit::where('status', -1)->get()->count();
	    	$visitedToday=VisitReport::whereDate('entryTimestamp', date('Y-m-d'))->where('status', '1')->get()->count();

	    	$appointmentRequests=Appointment::all()->count();
	    	$approvedAppointmentRequests=Appointment::where('status', 1)->get()->count();
	    	$pendingAppointmentRequests=Appointment::where('status', 0)->get()->count();
	    	$rejectedAppointmentRequests=Appointment::where('status', -1)->get()->count();
	    	$appointmentToday=AppointmentReport::whereDate('entryTimestamp', date('Y-m-d'))->where('status', '1')->get()->count();
	    }

	    else if(Auth::user()->role=='visitor'){
	    	$visitRequests=Visit::where('visitorId', Auth::user()->id)->count();
	    	$approvedVisitRequests=Visit::where([['visitorId', '=', Auth::user()->id], ['status', '=', 1]])->get()->count();
	    	$pendingVisitRequests=Visit::where([['visitorId', '=', Auth::user()->id], ['status', '=', 0]])->get()->count();
	    	$rejectedVisitRequests=Visit::where([['visitorId', '=', Auth::user()->id], ['status', '=', -1]])->get()->count();
	    	$visitedToday=0;

	    	$appointmentRequests=Appointment::where('visitorId', Auth::user()->id)->count();
	    	$approvedAppointmentRequests=Appointment::where([['visitorId', '=', Auth::user()->id], ['status', '=', 1]])->get()->count();
	    	$pendingAppointmentRequests=Appointment::where([['visitorId', '=', Auth::user()->id], ['status', '=', 0]])->get()->count();
	    	$rejectedAppointmentRequests=Appointment::where([['visitorId', '=', Auth::user()->id], ['status', '=', -1]])->get()->count();
	    	$appointmentToday=0;
	    }

	    else if(Auth::user()->role=='host'){
	    	$visitRequests=0;
	    	$approvedVisitRequests=0;
	    	$pendingVisitRequests=0;
	    	$rejectedVisitRequests=0;
	    	$visitedToday=0;

	    	$appointmentRequests=Appointment::where('hostId', Auth::user()->id)->count();
	    	$approvedAppointmentRequests=Appointment::where([['hostId', '=', Auth::user()->id], ['status', '=', 1]])->get()->count();
	    	$pendingAppointmentRequests=Appointment::where([['hostId', '=', Auth::user()->id], ['status', '=', 0]])->get()->count();
	    	$rejectedAppointmentRequests=Appointment::where([['hostId', '=', Auth::user()->id], ['status', '=', -1]])->get()->count();
	    	$appointmentToday=0;
	    }

    	$data=[
    		'visitors' => $visitors,
    		'hosts' => $hosts,
    		'visitRequests' => $visitRequests,
    		'approvedVisitRequests' => $approvedVisitRequests,
    		'pendingVisitRequests' => $pendingVisitRequests,
    		'rejectedVisitRequests' => $rejectedVisitRequests,
    		'visitedToday' => $visitedToday,
    		'appointmentRequests' => $appointmentRequests,
    		'approvedAppointmentRequests' => $approvedAppointmentRequests,
    		'pendingAppointmentRequests' => $pendingAppointmentRequests,
    		'rejectedAppointmentRequests' => $rejectedAppointmentRequests,
    		'appointmentToday' => $appointmentToday
    	];

    	return view('dashboard.index')->withData($data);
    }
}
