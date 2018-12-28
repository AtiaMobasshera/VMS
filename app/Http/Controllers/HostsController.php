<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use App\User;
use App\HostsDesignation;
use Session;
use DB;
use App\Profile;
use App\Appointment;

class HostsController extends Controller
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
        $hosts=DB::table('users')->join('hosts_designations', 'users.id', '=', 'hosts_designations.hostId')
                                ->join('designations', 'hosts_designations.designationId', '=', 'designations.id')
                                ->where('users.role', 'host')
                                ->select('users.*', 'designations.name as designation')
                                ->orderBy('users.id', 'DESC')
                                ->get();
        return view('hosts.index')->withHosts($hosts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designations=Designation::orderBy('name', 'ASC')->get();
        return view('hosts.create')->withDesignations($designations);
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
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'designationId' => 'required',
            'role' => 'required',
            'password' => 'required|string|min:5|confirmed',
        ));

        $user=new User();
        $user->name=ucwords($request->name);
        $user->email=strtolower($request->email);
        $user->role=strtolower($request->role);
        $user->password=bcrypt($request->password);
        $user->save();

        $hostDesignation=new HostsDesignation();
        $hostDesignation->hostId=$user->id;
        $hostDesignation->designationId=$request->designationId;
        $hostDesignation->save();

        Session::flash('hostAddSuccess', 'Successfully host added!');
        return redirect()->route('hosts.create');
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
        $profile=Profile::where('userId', $id)->first();
        $appointments=Appointment::where('hostId', $id)->first();

        if(empty($profile) && empty($appointments)){
            $hostDesignation=HostsDesignation::where('hostId', $id);
            $hostDesignation->delete();
            
            $host=User::find($id);
            $host->delete();

            Session::flash('hostDeleteSuccess', 'Host removed!');
        }
        else{
            Session::flash('hostDeleteFailed', 'Host can not be removed!');
        }
        return redirect()->route('hosts.index');
    }
}
