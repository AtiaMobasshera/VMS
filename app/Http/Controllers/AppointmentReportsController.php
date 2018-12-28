<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\AppointmentReport;
use Auth;
use Session;

class AppointmentReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\ReceptionistMiddleware');
    }

    public function index()
    {
    	return view('checkappointments.index');
    }

    public function check(Request $request)
    {
    	$code=$request->code;

    	$appointment=Appointment::where('code', $code)->first();

    	if(empty($appointment)){
    		Session::flash('invalidCode', 'Invalid Code');
    		return redirect()->route('checkAppointments.index');
    	}
    	else{
    		$report=AppointmentReport::where('appointmentId', $appointment->id)->first();
    		if(empty($report)){
    			return view('checkappointments.show')->withAppointment($appointment);
    		}
    		else{
    			return view('checkappointments.show')->withAppointment($appointment)->withReport($report);
    		}
    	}
    }

    public function proceed(Request $request)
    {
    	$this->validate($request, array(
    		'appointmentId' => 'required'
		));

    	$report=new AppointmentReport();
    	$report->appointmentId=(int)$request->appointmentId;
    	$report->receptionistId=Auth::user()->id;
    	$report->entryTimestamp=date('Y-m-d H:i:s');
    	$report->save();

    	Session::flash('proceedSuccess', 'User entry query successful');
    	return redirect()->route('checkAppointments.index');
    }

    public function terminate(Request $request)
    {
    	$this->validate($request, array(
    		'reportId' => 'required'
		));

		$report=AppointmentReport::find($request->reportId);
		$report->exitTimestamp=date('Y-m-d H:i:s');
		$report->status=1;
		$report->save();

		Session::flash('terminateSuccess', 'User exit query successful');
    	return redirect()->route('checkAppointments.index');
    }
}
