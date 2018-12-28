<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use Auth;
use PDF;

class AppointmentAccessCodesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\VisitorMiddleware');
    }

    public function download($id)
    {
    	$appointment=Appointment::find($id);

    	if(!empty($appointment)){
	    	if(Auth::user()->id==$appointment->visitorId){
	    		if($appointment->status==1){
	    			// $visitPdf=PDF::loadView('approved.appointments', ['appointment' => $appointment]);
	    			// return $visitPdf->download('test.pdf');
	    			$pdf=PDF::loadView('approved.appointments', ['appointment' => $appointment]);
	    			return $pdf->download('AppointmentCard.pdf');
	    		}
	    		else
	    			return abort(403);
	    	}
	    	else
	    		return abort(403);
    	}
    	else
    		return abort(404);
    }

}
