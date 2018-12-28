<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reason;
use Session;
use App\Visit;
use App\Appointment;

class VisitReasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\AdminMiddleware');
    }

    public function index()
    {
        $reasons=Reason::orderBy('name', 'ASC')->get();
        return view('reasons.index')->withReasons($reasons);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|unique:reasons|min:3'
        ));

        $reason=new Reason();
        $reason->name=strtolower($request->name);
        $reason->save();

        Session::flash('reasonAddSuccess', 'Successfully visit reason added!');
        return redirect()->route('visitreasons.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reason=Reason::find($id);

        if($reason->name==strtolower($request->name)){
            $this->validate($request, array(
                'name' => 'required|min:3'
            ));
        }
        else{
            $this->validate($request, array(
                'name' => 'required|unique:reasons|min:3'
            ));
        }

        $reason->name=strtolower($request->name);
        $reason->save();

        Session::flash('visitReasonUpdated', 'Visit reason successfully updated');
        return redirect()->route('visitreasons.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $visits=Visit::where('reasonId', $id)->first();
        $appointments=Appointment::where('reasonId', $id)->first();

        if(empty($visits) && empty($appointments)){
            $reason=Reason::find($id);
            $reason->delete();

            Session::flash('reasonDeleted', 'Reason delete success');
        }
        else{
            Session::flash('reasonDeleteFailed', 'Reason can not be deleted');
        }

        return redirect()->route('visitreasons.index');
    }
}
