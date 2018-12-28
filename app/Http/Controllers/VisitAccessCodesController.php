<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Visit;
use Auth;
use PDF;

class VisitAccessCodesController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\VisitorMiddleware');
    }

    public function download($id)
    {
    	$visit=Visit::find($id);

    	if(!empty($visit)){
	    	if(Auth::user()->id==$visit->visitorId){
	    		if($visit->status==1){
	    			// $visitPdf=PDF::loadView('approved.visits', ['visit' => $visit]);
	    			// return $visitPdf->download('test.pdf');
	    			$pdf=PDF::loadView('approved.visits', ['visit' => $visit]);
	    			return $pdf->download('VisitingCard.pdf');
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
