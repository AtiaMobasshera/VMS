<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Designation;
use Session;
use App\HostsDesignation;

class DesignationsController extends Controller
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
        $designations=Designation::orderBy('name', 'ASC')->get();
        return view('designations.index')->withDesignations($designations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('designations.create');
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
            'name' => 'required|min:3|unique:designations'
        ));

        $designation=new Designation();
        $designation->name=strtolower($request->name);
        $designation->save();

        Session::flash('designationAddSuccess', 'Successfully designation added!');
        return redirect()->route('designations.create');
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
        $designation=Designation::find($id);

        if($designation->name==strtolower($request->name)){
            $this->validate($request, array(
                'name' => 'required|min:3'
            ));
        }
        else{
            $this->validate($request, array(
                'name' => 'required|unique:designations|min:3'
            ));
        }

        $designation->name=strtolower($request->name);
        $designation->save();

        Session::flash('designationUpdated', 'Designation successfully updated');
        return redirect()->route('designations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hostDesignation=HostsDesignation::where('designationId', $id)->first();

        if(empty($hostDesignation)){
            $designation=Designation::find($id);
            $designation->delete();

            Session::flash('designationDeleteSuccess', 'Designation deleted successfully!');
        }
        else{
            Session::flash('designationDeleteFailed', 'Designation can not be deleted!');
        }
        return redirect()->route('designations.index');
    }
}
