<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AppointmentReport;
use Auth;

class ARAppointmentReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\AdminReceptionistMiddleware');
    }

    public function index()
    {
        if(Auth::user()->role=='admin'){
        	$reports=AppointmentReport::orderBy('id', 'DESC')->get();
        	return view('appointmentreports.index')->withReports($reports);
        }
        else if(Auth::user()->role=='receptionist')
            return redirect()->route('appointmentReports.show', Auth::user()->id);
    }

    public function show($id)
    {
        if(Auth::user()->id==$id){
            $reports=AppointmentReport::where('receptionistId', $id)->orderBy('id', 'DESC')->get();
            return view('appointmentreports.index')->withReports($reports);
        }
        else
            return abort(403);
    }

    public function today(){
        $reports=AppointmentReport::whereDate('entryTimestamp', date('Y-m-d'))->where('status', '1')->orderBy('id', 'DESC')->get();
        return view('appointmentreports.today')->withReports($reports);
    }
}
