<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VisitReport;
use Auth;

class ARVisitReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\AdminReceptionistMiddleware');
    }

    public function index()
    {
        if(Auth::user()->role=='admin'){
        	$reports=VisitReport::orderBy('id', 'DESC')->get();
        	return view('visitreports.index')->withReports($reports);
        }
        else if(Auth::user()->role=='receptionist')
            return redirect()->route('visitReports.show', Auth::user()->id);
    }

    public function show($id)
    {
        if(Auth::user()->id==$id){
            $reports=VisitReport::where('receptionistId', $id)->orderBy('id', 'DESC')->get();
            return view('visitreports.index')->withReports($reports);
        }
        else
            return abort(403);
    }

    public function today(){
        $reports=VisitReport::whereDate('entryTimestamp', date('Y-m-d'))->where('status', '1')->orderBy('id', 'DESC')->get();
        return view('visitreports.today')->withReports($reports);
    }
}
