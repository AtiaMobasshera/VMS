<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visit;
use App\VisitReport;
use Auth;
use Session;

class VisitReportsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\ReceptionistMiddleware');
    }

    public function index()
    {
    	return view('checkvisits.index');
    }

    public function check(Request $request)
    {
    	$code=$request->code;

    	$visit=Visit::where('code', $code)->first();

    	if(empty($visit)){
    		Session::flash('invalidCode', 'Invalid Code');
    		return redirect()->route('checkVisits.index');
    	}
    	else{
    		$report=VisitReport::where('visitId', $visit->id)->first();
    		if(empty($report)){
    			return view('checkvisits.show')->withVisit($visit);
    		}
    		else{
    			return view('checkvisits.show')->withVisit($visit)->withReport($report);
    		}
    	}
    }

    public function proceed(Request $request)
    {
    	$this->validate($request, array(
    		'visitId' => 'required'
		));

    	$report=new VisitReport();
    	$report->visitId=(int)$request->visitId;
    	$report->receptionistId=Auth::user()->id;
    	$report->entryTimestamp=date('Y-m-d H:i:s');
    	$report->save();

    	Session::flash('proceedSuccess', 'User entry query successful');
    	return redirect()->route('checkVisits.index');
    }

    public function terminate(Request $request)
    {
    	$this->validate($request, array(
    		'reportId' => 'required'
		));

		$report=VisitReport::find($request->reportId);
		$report->exitTimestamp=date('Y-m-d H:i:s');
		$report->status=1;
		$report->save();

		Session::flash('terminateSuccess', 'User exit query successful');
    	return redirect()->route('checkVisits.index');
    }
}
