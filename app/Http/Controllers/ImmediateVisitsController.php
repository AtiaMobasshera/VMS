<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reason;
use App\ImmediateVisit;
use Session;
use Image;
use Auth;
use App\User;
use File;

class ImmediateVisitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('App\Http\Middleware\AdminReceptionistMiddleware');
    }

    public function index()
    {
        $ivs=ImmediateVisit::orderBy('id', 'DESC')->get();
        return view('immediatevisits.index')->withIvs($ivs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reasons=Reason::orderBy('name', 'ASC')->get();
        return view('immediatevisits.create')->withReasons($reasons);
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
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric|min:5',
            'occupation' => 'required|min:3',
            'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2560',
            'reason' => 'required'
        ));

        $iv=new ImmediateVisit();
        $iv->name=ucwords($request->name);
        $iv->email=strtolower($request->email);
        $iv->phone=$request->phone;
        $iv->occupation=strtolower($request->occupation);

        if($request->hasFile('avatar')){
            $avatar=$request->file('avatar');
            $filename=time().'.'.$avatar->getClientOriginalExtension();
            $location=public_path('images/avatar/'.$filename);
            Image::make($avatar)->resize(400, 400)->save($location);

            $iv->avatar=$filename;
        }

        $admin=User::where('role', 'admin')->first();

        $iv->adminId=$admin->id;
        $iv->purpose=$request->reason;
        $iv->status=1;
        $iv->save();

        Session::flash('ivAdded', 'Immediate Visitor <b>'.ucwords($request->name).'</b> added!');
        return redirect()->route('immediatevisits.index');
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
        $iv=ImmediateVisit::find($id);
        $file=public_path().'/images/avatar/'.$iv->avatar;

        if(file_exists($file))
            File::Delete($file);
        $iv->delete();

        Session::flash('ivDeleted', 'Immediate visit deleted!');
        return redirect()->route('immediatevisits.index');
    }
}
