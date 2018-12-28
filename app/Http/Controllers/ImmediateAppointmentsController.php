<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reason;
use App\ImmediateAppointment;
use Session;
use Image;
use Auth;
use App\User;
use File;

class ImmediateAppointmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\AdminReceptionistMiddleware', ['except' => 'show']);
        $this->middleware('App\Http\Middleware\HostMiddleware', ['only' => 'show']);
    }

    public function index()
    {
        $ias=ImmediateAppointment::orderBy('id', 'DESC')->get();
        return view('immediateappointments.index')->withIas($ias);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hosts=User::where('role', 'host')->orderBy('name', 'ASC')->get();
        $reasons=Reason::orderBy('name', 'ASC')->get();
        return view('immediateappointments.create')->withHosts($hosts)->withReasons($reasons);
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
            'hostId' => 'required',
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric|min:5',
            'occupation' => 'required|min:3',
            'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2560',
            'reason' => 'required'
        ));

        $ia=new ImmediateAppointment();
        $ia->name=ucwords($request->name);
        $ia->email=strtolower($request->email);
        $ia->phone=$request->phone;
        $ia->occupation=strtolower($request->occupation);

        if($request->hasFile('avatar')){
            $avatar=$request->file('avatar');
            $filename=time().'.'.$avatar->getClientOriginalExtension();
            $location=public_path('images/avatar/'.$filename);
            Image::make($avatar)->resize(400, 400)->save($location);

            $ia->avatar=$filename;
        }

        $ia->hostId=$request->hostId;
        $ia->purpose=$request->reason;
        $ia->status=1;
        $ia->save();

        Session::flash('iaAdded', 'Immediate Visitor <b>'.ucwords($request->name).'</b> added!');
        return redirect()->route('immediateappointments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->id==$id)
        {
            $ias=ImmediateAppointment::where('hostId', $id)->orderBy('id', 'DESC')->get();
            return view('immediateappointments.show')->withIas($ias);
        }
        else
            return abort(403);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ia=ImmediateAppointment::find($id);
        $file=public_path().'/images/avatar/'.$ia->avatar;

        if(file_exists($file))
            File::Delete($file);
        $ia->delete();

        Session::flash('iaDeleted', 'Immediate appointment deleted!');
        return redirect()->route('immediateappointments.index');
    }
}
